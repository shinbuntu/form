<?php
/**
 * Test class for Mono
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Exception\tests\unit;

use atoum;
use Solire\Form\Exception\Mono as TestClass;

/**
 * Test class for Mono
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Mono extends atoum
{
    /**
     * Contrôle création de l'exception
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass('ok'))
                ->isInstanceOf('\Exception')
            ->exception(function () {
                throw new TestClass('message', 42);
            })
                ->hasCode(42)
                ->hasMessage('message')
        ;
    }

    /**
     * Contrôle enregistrement message formulaire
     *
     * @return void
     */
    public function testInputError()
    {
        $this
            ->if($exc = new TestClass('ok', 42))
            ->object($exc->setErrorInputName('nom'))
                ->isIdenticalTo($exc)
            ->string($exc->getTargetInputName())
                ->isEqualTo('nom')
        ;
    }
}
