<?php
/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

use Slrfw\Exception\Lib as Exception;

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

        throw new Exception('Aucune classe de test pour __' . $name . '__');
    }

    protected function validateProcess($className, $tool)
    {
        if (!in_array(__NAMESPACE__ . '\\' . $tool . 'Interface', class_implements($className))) {
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
        return $className::sanitize($this->foo, $param);
    }

    /**
     * Permet d'effectuer differents tests sur la variable
     *
     * @param array $options Tableau de tests à effectuer
     *
     * @return boolean
     */
    public function tests($options)
    {
        if (!is_array($options)) {
            throw new Exception('$options doit être un tableau');
        }

        foreach ($options as $option) {
            if ($this->validate($option) === true) {
                continue;
            }
            return false;
        }

        return true;
    }
}
