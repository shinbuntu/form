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
class VarMail implements ValidateInterface
{
    /**
     * Test si le parametre n'est pas vide.
     *
     * @param mixed $data  Valeur à tester
     * @param mixed $param Non utilisé
     *
     * @return boolean
     */
    public static function validate($data, $param = null)
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        return true;
    }
}
