<?php
/**
 * Interface des nettoyeurs
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

/**
 * Interface des nettoyeurs
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
interface SanitizeInterface
{
    /**
     * Formatage d'une donnée
     *
     * @param mixed  $data  Données du formulaire
     * @param string $param Configuration suplémentaire
     *
     * @return void
     * @throws Exception Pour marquer une erreur dans le formulaire
     */
    public static function sanitize($data, $param = null);
}
