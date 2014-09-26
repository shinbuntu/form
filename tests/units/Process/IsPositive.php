<?php
/**
 * Test class for IsPositive
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\IsPositive as TestClass;

/**
 * Test class for IsPositive
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class IsPositive extends atoum
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
                ->isTrue()
            ->boolean(TestClass::validate('01 42 53 68 95'))
                ->isTrue()
            ->boolean(TestClass::validate('allo'))
                ->isFalse()
            ->boolean(TestClass::validate('0'))
                ->isFalse()
            ->boolean(TestClass::validate(0))
                ->isFalse()
            ->boolean(TestClass::validate(-52))
                ->isFalse()
            ->boolean(TestClass::validate('-52'))
                ->isFalse()

        ;
    }
}
