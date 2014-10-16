<?php
/**
 * Test class for VarArray
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\VarArray as TestClass;

/**
 * Test class for VarArray
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class VarArray extends atoum
{
    /**
     * Contrôle validations de valeurs simple
     *
     * @return void
     */
    public function testCtrl()
    {
        $this
            ->boolean(TestClass::validate(5))
                ->isFalse()
            ->boolean(TestClass::validate('Allo'))
                ->isFalse()
            ->boolean(TestClass::validate([]))
                ->isTrue()
            ->boolean(TestClass::validate(['toto', 'tata']))
                ->isTrue()
            ->boolean(TestClass::validate(['foo' => 'bar']))
                ->isTrue()
        ;
    }
}
