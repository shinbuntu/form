<?php
/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Sowork\Formulaire\Validate;

use Sowork\Formulaire\ParamInterface;

/**
 * Contrôle de variables
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class IsInt implements ParamInterface
{
    /**
     * Test si le parametre est un entier
     *
     * @param mixed $data  Valeur à tester
     * @param mixed $param Non utilisé
     *
     * @return boolean
     */
    public static function validate($data, $param = null)
    {
        $options = [
            'options' => [
                'default' => false,
            ]
        ];

        if (!empty($param)) {
            $pattern = '#>=(?<min>[-0-9]+)#';
            if (preg_match($pattern, $param, $matchs)) {
                $options['options']['min_range'] = (int) $matchs['min'];
            }
            $pattern = '#<=(?<max>[-0-9]+)#';
            if (preg_match($pattern, $param, $matchs)) {
                $options['options']['max_range'] = (int) $matchs['max'];
            }
        }

        $var = filter_var($data, FILTER_VALIDATE_INT, $options);

        if ($var !== false) {
            return true;
        }

        return false;
    }
}
