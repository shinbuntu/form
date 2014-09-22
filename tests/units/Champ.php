<?php
/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace tests\unit\Sowork\Formulaire;

use atoum;
use Sowork\Formulaire\Champ as TestClass;

/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class Champ extends atoum
{
    /**
     * Renvoie un champ type
     *
     * @return TestClass
     */
    protected function getChampTest()
    {
        $foo = new TestClass('id');
        $foo
            ->setRule('test', 'isInt|notEmpty')
            ->setRule('obligatoire', true)
            ->setRule('designe', 'id-table')
        ;

        return $foo;
    }

    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass('id'))
                ->isInstanceOf('\Sowork\Formulaire\Champ')
        ;
    }

    /**
     * Gestion des règles
     *
     * @return void
     */
    public function testSetRule()
    {
        $this
            ->if($conf = new TestClass('id'))
            ->object($conf->setRule('test', 'isInt|notEmpty'))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('obligatoire', true))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('erreur', true))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('renomme', true))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('designe', true))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('exception', true))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('force', true))
                ->isIdenticalTo($conf)
            ->object($conf->setRule('egale', true))
                ->isIdenticalTo($conf)
            ->exception(function () use ($conf) {
                $conf->setRule('maRègleFoireuse', -1);
            })
                ->hasMessage('maRègleFoireuse n\'est pas une règle formulaire')
                ->isInstanceOf('\Slrfw\Exception\Lib')
        ;
    }

    /**
     * Contrôle du choix du nom d'entrée
     *
     * @return void
     */
    public function testGetTargetName()
    {
        $this
            ->if($field = $this->getChampTest())
            ->string($field->getTargetName())
                ->isEqualTo('id-table')
            ->if($field->rmRule('designe'))
            ->string($field->getTargetName())
                ->isEqualTo('id')
            ->if($field->setRule('designe', 'toto'))
            ->string($field->getTargetName())
                ->isEqualTo('toto')
        ;
    }

    /**
     * Contrôle du choix nom de sortie
     *
     * @return void
     */
    public function testGetFinalName()
    {
        $this
            ->if($field = $this->getChampTest())
            ->string($field->getFinalName())
                ->isEqualTo('id')
            ->if($field->setRule('renomme', 'tata'))
            ->string($field->getFinalName())
                ->isEqualTo('tata')
        ;
    }

    /**
     * Contrôle d'indication obligatoire
     *
     * @return void
     */
    public function testIsRequired()
    {
        $this
            ->if($field = $this->getChampTest())
            ->boolean($field->isRequired())
                ->isTrue()
            ->if($field->setRule('obligatoire', false))
            ->boolean($field->isRequired())
                ->isFalse()
            ->if($field->rmRule('obligatoire'))
            ->boolean($field->isRequired())
                ->isFalse()
        ;
    }

    /**
     * Contrôle de la liste des tests
     *
     * @return void
     */
    public function testGetTests()
    {
        $this
            ->if($field = $this->getChampTest())
            ->array($field->getTests())
                ->isEqualTo(['isInt', 'notEmpty'])
            ->if($field->setRule('test', ['isMail', 'notEmpty']))
            ->array($field->getTests())
                ->isEqualTo(['isMail', 'notEmpty'])
            ->if($field->rmRule('test'))
            ->array($field->getTests())
                ->isEqualTo([])
        ;
    }

    /**
     * Contrôle gestion des exceptions personalisées
     *
     * @return void
     */
    public function testPersonalException()
    {
        $this
            ->if($field = $this->getChampTest())
            ->boolean($field->hasPersonalException())
                ->isFalse()
            ->exception(function () use ($field) {
                $field->getPersonalException();
            })
                ->hasMessage('Aucune class exception de configurée pour ce champ')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->if($field->setRule('exception', ''))
            ->boolean($field->hasPersonalException())
                ->isFalse()
            ->exception(function () use ($field) {
                $field->getPersonalException();
            })
                ->hasMessage('Aucune class exception de configurée pour ce champ')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->if($field->setRule('exception', 'Sowork\\Toto'))
            ->boolean($field->hasPersonalException())
                ->isTrue()
            ->string($field->getPersonalException())
                ->isEqualTo('Sowork\\Toto')
        ;
    }

    /**
     * Contrôle des retours erreur
     *
     * @return void
     */
    public function testGetErrorMessage()
    {
        $this
            ->if($field = $this->getChampTest())
            ->string($field->getErrorMessage())
                ->isEqualTo('id')
            ->if($field->setRule('erreur', 'Veuillez choisir un produit.'))
            ->string($field->getErrorMessage())
                ->isEqualTo('Veuillez choisir un produit.')
        ;
    }
}
