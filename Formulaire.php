<?php
/**
 * Module de gestion de formulaires
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Sowork\Formulaire;

use Slrfw\Exception\Lib as Exception;
use Slrfw\Exception\Internal;
use \Sowork\Formulaire\Champ;

/**
 * Contrôle des formulaires
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class Formulaire
{
    /**
     * Nom de la section pour la configuration globale
     */
    const CONFIG = '__global';

    /**
     * Force le retour de run() sous forme d'une liste
     */
    const FORMAT_LIST = 1;

    /**
     * Ordre dans lesquels les tableaux sont mergés
     *
     * p pour $_POST
     * g pour $_GET
     * c pour $_COOKIE
     *
     * @var string
     */
    protected $defaultOrder = 'cgp';

    /**
     * Liste des plugins
     *
     * @var array
     */
    protected $plugins;

    /**
     * valeur --config dans le fichier de configuration du formulaire
     *
     * @var array
     */
    protected $config;

    /**
     * Données du formulaire
     *
     * @var array
     */
    protected $data;

    /**
     * Nom du champ en cours d'annalyse
     *
     * @var string
     */
    protected $target = '';

    /**
     * Liste des noms des champs du formulaire
     *
     * @var array
     */
    protected $inputNames = [];

    /**
     * Charge un nouveau formulaire
     *
     * @param Slrfw\ConfigInterface $config Configuration du Formulaire
     */
    public function __construct($config)
    {
        if (!is_object($config) || !in_array('Slrfw\ConfigInterface', class_implements($config))) {
            throw new Exception('Configuration non valide');
        }

        $this->config = $config;
    }

    /**
     * Renvois la configuration du formulaire
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Chargement du champ à étudier
     *
     * @param string      $name  Nom du champ
     * @param array|Champ $rules Données du champ
     *
     * @return \Slrfw\Formulaire\Champ
     */
    protected function loadChamp($name, $rules)
    {
        if (is_object($rules) && $rules instanceof Champ) {
            return $rules;
        }

        $champ = new Champ($name);

        foreach ($rules as $key => $value) {
            $champ->setRule($key, $value);
        }

        return $champ;
    }

    /**
     * Renvois le nom du champ à récupérer dans les variables http
     *
     * @param Champ $field Champ en cours de traitement
     *
     * @return string
     */
    protected function getFieldName(Champ $field)
    {
        $target = $field->getTargetName();

        if ($this->config->get(self::CONFIG, 'prefix') !== null) {
            $target = $this->config->get(self::CONFIG, 'prefix') . $target;
        }

        $this->inputNames[] = $target;

        return $target;
    }

    /**
     * Traite le formulaire pour en renvoyer les données vérifiées
     *
     * @return array tableau des données du formulaire
     *
     * @throws Exception\Lib  En cas d'erreurs dans la configuration du formulaire
     * @throws Exception\User Si le formulaire est mal remplis
     *
     * @uses Formulaire::catchData()
     * @uses Formulaire::get()
     */
    public function run()
    {
        $this->fullData = $this->catchData();
        $configuration = $this->config->getAll();

        unset($configuration[self::CONFIG]);

        /* = On utilise cette formulation plutot que foreach parce que
         * $configuration peut évoluer dans la boucle. (et que dans un foreach
         * cela n'est pas pris en compte)
          ------------------------------- */
        reset($configuration);
        while (list($name, $regles) = each($configuration)) {
            $champ = $this->loadChamp($name, $regles);

            try {
                $temp = $this->extractFromHttpVars($champ);
            } catch (Internal $exc) {
                continue;
            }

            $controls = $champ->getTests();

            /* = Si la variable ne passe pas les testes
            | on retourne un message d'erreur si celle-ci est
            | obligatoire, sinon, on l'ignore simplement.
            `---------------------------------------- */
            if (!$temp->tests($controls)) {
                $this->markError($champ, false);

                continue;
            }

            $name = $champ->getFinalName();
            $this->data[$name] = $temp->get();
            unset($temp);

//            /* = Passage en obligatoire des champs liés
//              ------------------------------- */
//            if (isset($regles['force'])) {
//                $champs = explode('|', $regles['force']);
//                foreach ($champs as $champ) {
//                    $configuration[$champ]['obligatoire'] = true;
//                }
//                unset($champs, $champ);
//            }
//
//            /* = Contrôle d'egalité du champ
//              ------------------------------- */
//            if (isset($regles['egal'])) {
//                if ($this->_data[$name] != $this->_data[$regles['egal']]) {
//                    $this->throwError($regles);
//                }
//            }
        }

//        if (!empty($this->plugins)) {
//            foreach ($this->plugins as $plugin) {
//                if (in_array('Slrfw\Formulaire\PluginInterface', class_implements($plugin))) {
//                    $plugin::form($this->_data);
//                } else {
//                    $this->throwError(array('erreur' => 'plugin incompatible'));
//                }
//            }
//        }

        $options = func_get_args();
        if (!empty($options)) {
            if ($options[0] == self::FORMAT_LIST) {
                return $this->getList();
            }
        }

        return $this->data;
    }

    /**
     * Renvois les données collectées par le formulaire sous la forme d'un tableau
     *
     * @return array Tableau non associatif des valeurs
     */
    public function getList()
    {
        $list = array();
        foreach ($this->data as $value) {
            $list[] = $value;
        }

        return $list;
    }

    /**
     * Envoie l'exception de l'erreur.
     *
     * Le type d'exception envoyé peut être paramétré à deux endroits,
     * au niveau du champ (option _exception_), ou au niveau du de la configuration
     * globale.
     * Par défaut une {@link Slrfw\Exception\Lib} est envoyée.
     *
     * @param Champ $field Champ responçable de l'erreur
     *
     * @return void
     * @throws mixed         En cas d'erreur sur un champ
     * @throws Exception\Lib Si il y a une erreur dans le formulaire
     */
    protected function throwError(Champ $field)
    {
        $message = $field->getErrorMessage();

        if ($field->hasPersonalException() === true) {
            // Exception personnalisée au niveau du champ
            $className = $field->getPersonalException();
            $error = new $className($message);
        } elseif ($this->config->get(self::CONFIG, 'exception') !== null) {
            // Exception personnalisée au niveau du formulaire
            $className = $this->config->get(self::CONFIG, 'exception');
            $error = new $className($message);
        } else {
            $className = 'Exception';
            $error = new Exception($message);
        }

        if (method_exists($error, 'setErrorInputName')) {
            $error->setErrorInputName($this->target);
        }

//        if (isset($this->_config['appelFonction'])) {
//            if (is_callable($this->_config['appelFonction'])) {
//                $error = call_user_func(
//                    $this->_config['appelFonction'], $this, $error
//                );
//            }
//        }
        throw $error;
    }

    /**
     * Récupère les données GET POST COOKIE
     *
     * @return array
     */
    protected function catchData()
    {
        $datas = [
            'g' => $_GET,
            'p' => $_POST,
            'c' => $_COOKIE,
        ];

        $order = $this->defaultOrder;
        if ($this->config->get(self::CONFIG, 'ordre') !== null) {
            $order = $this->config->get(self::CONFIG, 'ordre');
        }

        $result = [];
        for ($i = 0; $i < strlen($order); $i++) {
            $httpVar = $order[$i];
            if (isset($datas[$httpVar]) && !empty($datas[$httpVar])) {
                $result = array_merge($result, $datas[$httpVar]);
            }
        }
        return $result;
    }

    /**
     * Renvois la liste des champs input du formulaire
     *
     * @return array
     */
    public function getInputNamesList()
    {
        return $this->inputNames;
    }

    /**
     * Renvois le paramètre du nom $key sous la forme d'un objet Param
     *
     * @param Champ $field Champ pour lequel récupérer les données
     *
     * @return Param|null
     */
    protected function extractFromHttpVars(Champ $field)
    {
        $key = $this->getFieldName($field);

        if (isset($this->fullData[$key])) {
            return new Param($this->fullData[$key]);
        }

        return $this->markError($field);
    }

    /**
     * Marque le champ en erreur
     *
     * @param Champ   $field Champ responçable de l'erreur
     * @param boolean $throw Lancer une exception si champ ignoré oui/non
     *
     * @return void
     * @throws Internal si l'erreur ne doit pas être marqué
     */
    protected function markError(Champ $field, $throw = true)
    {
        if ($field->isRequired() === true) {
            return $this->throwError($field);
        }

        if ($throw === true) {
            throw new Internal('Ignore field');
        }
    }

    /**
     * Renvois les données collectées par le formulaire sous la forme
     * d'un tableau associatif
     *
     * @return array
     */
    public function getArray()
    {
        return $this->data;
    }


    /**
     * __get() est sollicitée pour lire des données depuis des propriétés inaccessibles
     *
     * Cette focntion permet d'appeller les variables du formulaire directement par $obj->var
     *
     * @param string $name Nom de la variable
     *
     * @return null
     * @ignore
     */
    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

    /**
     * __isset() est sollicitée pour tester des données depuis des propriétés inaccessibles
     *
     * Cette fonction permet de tester (isset()) les variables
     *
     * @param string $name Nom de la variable
     *
     * @return boolean
     * @ignore
     */
    public function __isset($name)
    {
        if (isset($this->data[$name])) {
            return true;
        }

        return false;
    }
}
