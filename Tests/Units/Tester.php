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
     * Contrôles & Nettoyages sur la variable
     *
     * @return void
     */
    public function testRun()
    {
        $this
            ->if($var = new TestClass('id'))
            ->string($var->get())
                ->isEqualTo('id')
            ->boolean($var->run(['VarString', 'length:>=2']))
                ->isTrue()
            ->exception(function () use ($var) {
                $var->run(42);
            })
                ->hasMessage('$tests doit être un tableau')
                ->isInstanceOf('\Solire\Form\Exception')
            ->boolean($var->run(['\\Solire\\Form\\Process\\VarInt']))
                ->isFalse()
            ->exception(function () use ($var) {
                $var->run(['\\Solire\\Form\\Process\\PouetPouet']);
            })
                ->hasMessage('Aucune classe trouvée pour __\Solire\Form\Process\PouetPouet__')
                ->isInstanceOf('\Solire\Form\Exception')
            ->exception(function () use ($var) {
                $var->run(['\\Solire\\Form\\Field']);
            })
                ->hasMessage('_\Solire\Form\Field_ n\'implemente pas ValidateInterface')
                ->isInstanceOf('\Solire\Form\Exception')

            ->exception(function () use ($var) {
                $var->run(['VarString', 'length:>=2'], 42);
            })
                ->hasMessage('$sanitizes doit être un tableau')
                ->isInstanceOf('\Solire\Form\Exception')
            ->exception(function () use ($var) {
                $var->run(['VarString', 'length:>=2'], ['\\Solire\\Class\\Not\\Exist']);
            })
                ->hasMessage('Aucune classe trouvée pour __\Solire\Class\Not\Exist__')
                ->isInstanceOf('\Solire\Form\Exception')
            ->exception(function () use ($var) {
                $var->run(['VarString', 'length:>=2'], ['\\Solire\\Form\\Field']);
            })
                ->hasMessage('_\Solire\Form\Field_ n\'implemente pas SanitizeInterface')
                ->isInstanceOf('\Solire\Form\Exception')
            ->boolean($var->run(['VarString', 'length:>=2'], ['\\Solire\\Form\\Process\\VarFloat']))
                ->isTrue()
            ->float($var->get())
                ->isEqualTo(0.0)
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

    /**
     * Contrôles sur la variable
     *
     * @return void
     */
    public function testValidate()
    {
        $this
            ->if($var = new TestClass('3.252'))
            ->string($var->get())
                ->isEqualTo('3.252')
            ->boolean($var->validate('VarFloat'))
                ->isTrue()
            ->if($var = new TestClass('sdf3.25d2'))
            ->boolean($var->validate('VarFloat'))
                ->isFalse()
        ;
    }
}
