<?php
/**
  * Exemple d'exception utilisant le retour Mono
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Exception;

/**
 * Exemple d'exception utilisant le retour Mono
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Mono extends \Exception
{
    use MonoTrait;
}
