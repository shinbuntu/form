<?php
/**
 * Interface des plugins formulaire
 *
 * @author  Siwaÿll <sanath.labs@gmail.com>
 * @license
 */

namespace Solire\Form;

/**
 * Interface des plugins formulaire
 *
 * @author  Siwaÿll <sanath.labs@gmail.com>
 * @license
 */
interface ParamInterface
{
    /**
     * Validation du format d'une donnée
     *
     * @param array $data Données du formulaire
     *
     * @return void
     * @throws Exception Pour marquer une erreur dans le formulaire
     */
    public static function validate($data, $param);
}