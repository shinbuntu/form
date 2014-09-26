<?php
/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process;

use Solire\Form\ValidateInterface;

/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class VarBoolean implements ValidateInterface
{
    /**
     * Test si le parametre est un boolean
     *
     * @param mixed $data  Valeur à tester
     * @param mixed $param Non utilisé
     *
     * @return boolean
     */
    public static function validate($data, $param = null)
    {
        $bool = filter_var($data, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($bool === true || $bool === false) {
            return true;
        }

        return false;
    }
}
