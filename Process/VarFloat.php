<?php
/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process;

use Solire\Form\ValidateInterface;
use Solire\Form\SanitizeInterface;

/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class VarFloat implements ValidateInterface, SanitizeInterface
{
    /**
     * Test si la valeur est un nombre
     *
     * @param mixed $data  Valeur à tester
     * @param mixed $param Non utilisé
     *
     * @return boolean
     */
    public static function validate($data, $param = null)
    {
        if (filter_var($data, FILTER_VALIDATE_FLOAT) === false) {
            return false;
        }

        return true;
    }

    /**
     * Nettoie la variable pour avoir un float
     *
     * @param mixed $data  Valeur à Nettoyer
     * @param mixed $param Non utilisé
     *
     * @return float
     */
    public static function sanitize($data, $param = null)
    {
        return (float) filter_var(
            $data,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );
    }
}
