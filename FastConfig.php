<?php
/**
 * Gestionnaire des fichiers de configurations
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form;

use Solire\Conf\ConfigInterface;

/**
 * Gestionnaire des fichiers de configurations
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class FastConfig extends \Solire\Conf\Conf implements ConfigInterface
{
    /**
     * Configuration par défaut d'une valeur
     *
     * @var array
     */
    private $default = [
        'test' => '',
        'obligatoire' => false,
    ];

    private $rules = [
        'test', 'obligatoire', 'erreur', 'renomme', 'designe', 'exception',
        'force', 'egale', 'sanitize'
    ];

    private $varName;

    /**
     * Ajoute un champ dans la configuration du formulaire
     *
     * @param string $varName Nom du champs à ajouter
     *
     * @return self
     */
    public function create($varName)
    {
        $elmt = new self();
        $elmt
            ->set('', 'test')
            ->set(false, 'obligatoire')
        ;
        $this->set($elmt, $varName);
        $this->varName = $varName;

        return $this;
    }

    /**
     * Ajoute une règle au dernier champ créé
     *
     * @param string $ruleName Nom de la règle à ajouter
     * @param mixed  $value    Valeur de l'option
     *
     * @return self
     * @throws Exception si la règle demandée n'existe pas
     */
    public function setRule($ruleName, $value)
    {
        if (!in_array($ruleName, $this->rules)) {
            throw new Exception($ruleName . ' n\'est pas une règle formulaire');
        }

        $this->set($value, $this->varName, $ruleName);

        return $this;
    }
}
