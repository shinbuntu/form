<?php
/**
 * Chargement de la session client
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

/**
 * Chargement de la session client
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
trait ExceptionTrait
{
    protected $targetInput = '';
    /**
     * Enregistre le nom de l'input qui contien une erreur
     *
     * @param string|array $inputName nom de l'input fautif
     *
     * @return self
     */
    public function setErrorInputName($inputName)
    {
        $this->targetInput = $inputName;

        return $this;
    }

    /**
     * Renvois le nom du champ du formulaire qui pose problème
     *
     * @return type
     */
    public function getTargetInputName()
    {
        return $this->targetInput;
    }
}
