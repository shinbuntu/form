<?php
/**
 * Enregistrement d'informations suplémentaires pour les exception envoyés par
 * les contrôles de formulaire
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

/**
 * Enregistrement d'informations suplémentaires pour les exception envoyés par
 * les contrôles de formulaire
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
trait ExceptionTrait
{
    /**
     * Nom du champs à cibler
     *
     * @var string
     */
    protected $targetInput = '';

    /**
     * Enregistre le nom de l'input qui contien une erreur
     *
     * @param string|array $inputName Nom de l'input fautif
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
