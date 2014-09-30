<?php
/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Tester
{
    /**
     * Variable
     *
     * @var mixed
     */
    private $foo = null;

    /**
     * Charge une nouvelle variable
     *
     * @param mixed $param Valeur de la variable à tester
     */
    public function __construct($param = null)
    {
        $this->foo = $param;
    }

    /**
     * Retourne la valeur du paramètre.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->foo;
    }

    /**
     * Renvoie le nom de la classe de test
     *
     * @param string $name Nom du test
     * @param string $tool Nom du modèle de script à valider (sanitize, validate...)
     *
     * @return string
     */
    protected function getClassName($name, $tool)
    {
        $className = __NAMESPACE__ . '\\Process\\' . ucfirst($name);
        if (class_exists($className)) {
            return $this->validateProcess($className, $tool);
        }

        if (class_exists($name)) {
            return $this->validateProcess($name, $tool);
        }

        throw new Exception('Aucune classe trouvée pour __' . $name . '__');
    }

    /**
     * Contrôle si la classe demandé implémente l'interface du type de script
     * demandé
     *
     * @param string $className Nom de la classe
     * @param string $tool      Nom du type de script
     *
     * @return string
     * @throws Exception si la classe demandée n'implémente pas l'interface
     */
    protected function validateProcess($className, $tool)
    {
        $interfaces = class_implements($className);
        if (!isset($interfaces[__NAMESPACE__ . '\\' . $tool . 'Interface'])) {
            throw new Exception('_' . $className . '_ n\'implemente pas ' . $tool . 'Interface');
        }

        return $className;
    }

    /**
     * Extrait les options du nom du traitement
     *
     * @param string $name Nom du traitement
     *
     * @return string[]
     */
    protected function extractOptions($name)
    {
        if (strpos($name, ':') === false) {
            return [$name, null];
        }
        $foo = explode(':', $name);
        return $foo;
    }

    /**
     * Execute un test sur la variable
     *
     * @param string $option Nom du test à effectuer
     *
     * @return boolean
     */
    public function validate($option)
    {
        list($option, $param) = $this->extractOptions($option);
        $className = $this->getClassName($option, 'Validate');
        return $className::validate($this->foo, $param);
    }

    /**
     * Execute un traitement sur la variable
     *
     * @param string $option Nom du traitement à effectuer
     *
     * @return boolean
     */
    public function sanitize($option)
    {
        list($option, $param) = $this->extractOptions($option);
        $className = $this->getClassName($option, 'Sanitize');
        $this->foo = $className::sanitize($this->foo, $param);
        return $this->foo;
    }

    /**
     * Permet d'effectuer differents tests sur la variable
     *
     * @param array $tests     Tableau de tests à effectuer
     * @param array $sanitizes Tableau de nettoyages à effectuer
     *
     * @return boolean
     */
    public function run($tests, $sanitizes = [])
    {
        if (!is_array($tests)) {
            throw new Exception('$tests doit être un tableau');
        }

        foreach ($tests as $option) {
            if ($this->validate($option) === true) {
                continue;
            }
            return false;
        }

        if (!is_array($sanitizes)) {
            throw new Exception('$sanitizes doit être un tableau');
        }
        foreach ($sanitizes as $option) {
            $this->sanitize($option);
        }

        return true;
    }
}
