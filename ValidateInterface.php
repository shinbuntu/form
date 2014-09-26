<?php
/**
 * Interface des plugins formulaire
 *
 * @author  Siwaÿll <sanath.labs@gmail.com>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

/**
 * Interface des plugins formulaire
 *
 * @author  Siwaÿll <sanath.labs@gmail.com>
 * @license MIT http://mit-license.org/
 */
interface ValidateInterface
{
    /**
     * Validation du format d'une donnée
     *
     * @param mixed  $data  Données du formulaire
     * @param string $param Configuration suplémentaire
     *
     * @return void
     * @throws Exception Pour marquer une erreur dans le formulaire
     */
    public static function validate($data, $param);
}
