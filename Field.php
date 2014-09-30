<?php
/**
 * Module de gestion de formulaires
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

/**
 * Contrôle des formulaires
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Field
{
    /**
     * @var array Règles acceptées par Formulaire
     */
    private $rules = [
        'test', 'obligatoire', 'erreur', 'renomme', 'designe', 'exception',
        'sanitize',
        'force', 'egale'
    ];

    /**
     * @var string Nom du champ
     */
    protected $name;

    /**
     * @var array Configuration du champ
     */
    protected $config = [];

    /**
     * Règles pour un champ du formulaire
     *
     * @param string $name Nom du champ
     */
    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Ajoute une règle au dernier champ créé
     *
     * @param string $ruleName Nom de la règle à ajouter
     * @param mixed  $value    Valeur de l'option
     *
     * @return self
     * @throws Exception si la règle demandée n'existe pas
     */
    public function setRule($ruleName, $value)
    {
        if (!in_array($ruleName, $this->rules)) {
            throw new Exception($ruleName . ' n\'est pas une règle formulaire');
        }

        $this->config[$ruleName] = $value;

        return $this;
    }

    /**
     * Supprime une règle
     *
     * @param string $ruleName Nom de la règle à supprimer
     *
     * @return self
     */
    public function rmRule($ruleName)
    {
        unset($this->config[$ruleName]);

        return $this;
    }

    /**
     * Renvoie le nom de l'attribut GET / POST ou COOKIE du champ
     *
     * @return string
     */
    public function getTargetName()
    {
        if (isset($this->config['designe'])) {
            return $this->config['designe'];
        }

        return $this->name;
    }

    /**
     * Renvoie le nom de l'attribut de sortie
     *
     * @return string
     */
    public function getFinalName()
    {
        if (isset($this->config['renomme'])) {
            return $this->config['renomme'];
        }

        return $this->name;
    }

    /**
     * Renvoie le message d'erreur à afficher si le champ n'est pas correcte.
     *
     * Le message peut être configuré via l'option __erreur__.
     * Par défaut le message est le nom du champ
     *
     * @return string
     */
    public function getErrorMessage()
    {
        if (isset($this->config['erreur'])) {
            return $this->config['erreur'];
        }

        return $this->name;
    }

    /**
     * Indique si le champ possède une personnalisation au niveau de l'exception
     *
     * @return boolean
     */
    public function hasPersonalException()
    {
        if (!isset($this->config['exception'])) {
            return false;
        }

        if (empty($this->config['exception'])) {
            return false;
        }

        return true;
    }

    /**
     * Renvoie le nom de la classe à utiliser comme exception
     *
     * @return string
     * @throws Exception si aucune exception n'est configurée
     */
    public function getPersonalException()
    {
        if (!isset($this->config['exception']) || empty($this->config['exception'])) {
            throw new Exception('Aucune class exception de configurée pour ce champ');
        }

        return $this->config['exception'];
    }

    /**
     * Indique si le champ est requis
     *
     * @return boolean
     */
    public function isRequired()
    {
        if (isset($this->config['obligatoire'])) {
            return (boolean) $this->config['obligatoire'];
        }

        return false;
    }

    /**
     * Renvoie un tableau de configuration
     *
     * @param string $name Nom du champ
     *
     * @return array
     */
    protected function getArrayConfOf($name)
    {
        if (!isset($this->config[$name])) {
            return [];
        }

        if (is_array($this->config[$name])) {
            return $this->config[$name];
        }

        return explode('|', $this->config[$name]);
    }

    /**
     * Renvoie les noms des testes à effectuer sur le champ
     *
     * @return array
     */
    public function getTests()
    {
        return $this->getArrayConfOf('test');
    }

    /**
     * Renvoie les noms des nettoyages à faire sur le champ
     *
     * @return type
     */
    public function getSanitizes()
    {
        return $this->getArrayConfOf('sanitize');
    }
}
