<?php
/**
 * Test class for NotEmpty
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\NotEmpty as TestClass;

/**
 * Test class for NotEmpty
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class NotEmpty extends atoum
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
            ->boolean(TestClass::validate(''))
                ->isFalse()
            ->boolean(TestClass::validate('0'))
                ->isFalse()
            ->boolean(TestClass::validate(false))
                ->isFalse()
            ->boolean(TestClass::validate(null))
                ->isFalse()
            ->boolean(TestClass::validate('null'))
                ->isTrue()
        ;
    }
}
