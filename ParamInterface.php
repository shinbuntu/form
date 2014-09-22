<?php
/**
 * Interface des plugins formulaire
 *
 * @author  Siwaÿll <sanath.labs@gmail.com>
 * @license 
 */

namespace Sowork\Formulaire;

/**
 * Interface des plugins formulaire
 *
 * @author  Siwaÿll <sanath.labs@gmail.com>
 * @license
 */
interface ParamInterface
{
    /**
     * Traitement sur les données d'un formulaire
     *
     * @param array $data Données du formulaire
     *
     * @return void
     * @throws Exception Pour marquer une erreur dans le formulaire
     */
    public static function validate($data, $param);
}