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
class Length implements ValidateInterface
{
    /**
     * Test si le parametre n'est pas vide.
     *
     * @param mixed $data  Valeur à tester
     * @param mixed $param Signe et valeur minimum **par exemple >=2**
     *
     * @return boolean
     */
    public static function validate($data, $param)
    {
        $sign = preg_replace('#([0-9]+)#', '', $param);
        $length = str_replace($sign, '', $param);

        switch ($sign) {
            case '=':
                if (strlen($data) == $length) {
                    return true;
                }
                break;
            case '>=':
                if (strlen($data) >= $length) {
                    return true;
                }
                break;
            case '<=':
                if (strlen($data) <= $length) {
                    return true;
                }
                break;
            case '>':
                if (strlen($data) > $length) {
                    return true;
                }
                break;
            case '<':
                if (strlen($data) < $length) {
                    return true;
                }
                break;

        }

        return false;
    }
}
