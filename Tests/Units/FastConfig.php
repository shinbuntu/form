<?php
/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Tests\Units;

use atoum;
use Solire\Form\FastConfig as TestClass;
use Solire\Conf\Tests\Units\Conf as AtoumConf;

/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class FastConfig extends AtoumConf
{
    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass())
        ;
    }

    /**
     * Test d'utilisation du process de création d'une règle formulaire
     *
     * @return void
     */
    public function testCreate()
    {
        $this
            ->if($conf = new TestClass())
            ->object($conf->create('id'))
                ->isIdenticalTo($conf)
            ->dump($conf)
            ->string($conf->get('id', 'test'))
                ->isEqualTo('')
            ->boolean($conf->get('id', 'obligatoire'))
                ->isFalse()

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
                ->isInstanceOf('\Solire\Form\Exception')
        ;
    }
}
