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
class VarInt implements ValidateInterface
{
    /**
     * Test si le parametre est un entier
     *
     * Exemple de paramétrages.
     * _>=4 <=10_ pour une valeur comprise entre 4 et 10 inclus.
     * _>=0_ pour une valeur positive
     * _<=0_ pour une valeur négative
     *
     * @param mixed       $data  Valeur à tester
     * @param string|null $param Sous la forme d'une paire d'indicateur ">=X"
     * où X est la valeur minimale acceptable et "<=Y" où Y est la valeur
     * maxiaml acceptable
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
