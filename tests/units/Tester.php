<?php
/**
 * Test class for Tester.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\tests\unit;

use atoum;
use Solire\Form\Tester as TestClass;

/**
 * Test class for Tester.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Tester extends atoum
{
    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass('id'))
        ;
    }

    /**
     * Contrôles sur la variable
     *
     * @return void
     */
    public function testTest()
    {
        $this
            ->if($var = new TestClass('id'))
            ->string($var->get())
                ->isEqualTo('id')
            ->boolean($var->tests(['VarString', 'length:>=2']))
                ->isTrue()
            ->boolean($var->validate('VarString'))
                ->isTrue()
            ->exception(function () use ($var) {
                $var->tests(52);
            })
                ->hasMessage('$options doit être un tableau')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->boolean($var->tests(['\\Solire\\Form\\Process\\VarInt']))
                ->isFalse()
            ->exception(function () use ($var) {
                $var->tests(['\\Solire\\Form\\Process\\PouetPouet']);
            })
                ->hasMessage('Aucune classe de test pour __\Solire\Form\Process\PouetPouet__')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->exception(function () use ($var) {
                $var->tests(['\\Solire\\Form\\Field']);
            })
                ->hasMessage('_\Solire\Form\Field_ n\'implemente pas ValidateInterface')
                ->isInstanceOf('\Slrfw\Exception\Lib')
        ;
    }

    /**
     * Traitements sur la variable
     *
     * @return void
     */
    public function testSanitize()
    {
        $this
            ->if($var = new TestClass('3.252'))
            ->string($var->get())
                ->isEqualTo('3.252')
            ->float($var->sanitize('VarFloat'))
                ->isEqualTo(3.252)
            ->if($var = new TestClass('sdf3.25d2'))
            ->string($var->get())
                ->isEqualTo('sdf3.25d2')
            ->float($var->sanitize('VarFloat'))
                ->isEqualTo(3.252)

        ;
    }
}
