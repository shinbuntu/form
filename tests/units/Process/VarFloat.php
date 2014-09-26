<?php
/**
 * Test class for VarFloat
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\VarFloat as TestClass;

/**
 * Test class for VarFloat
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class VarFloat extends atoum
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
            ->boolean(TestClass::validate(15))
                ->isTrue()
            ->boolean(TestClass::validate(-5365))
                ->isTrue()
            ->boolean(TestClass::validate(5365.000))
                ->isTrue()
            ->boolean(TestClass::validate('+564654'))
                ->isTrue()
            ->boolean(TestClass::validate('8565'))
                ->isTrue()
            ->boolean(TestClass::validate('-65489'))
                ->isTrue()
            ->boolean(TestClass::validate(0.256))
                ->isTrue()
            ->boolean(TestClass::validate('a523'))
                ->isFalse()
            ->boolean(TestClass::validate('0.6'))
                ->isTrue()
            ->boolean(TestClass::validate('-5648.5'))
                ->isTrue()
            ->boolean(TestClass::validate('-564d85'))
                ->isFalse()
        ;
    }

    /**
     * Contrôle traitements de valeurs simple
     *
     * @return void
     */
    public function testSanitize()
    {
        $this
            ->float(TestClass::sanitize(5))
                ->isEqualTo(5.0)
            ->float(TestClass::sanitize('5'))
                ->isEqualTo(5.0)
            ->float(TestClass::sanitize('-5365'))
                ->isEqualTo(-5365.0)
            ->float(TestClass::sanitize('-5365'))
                ->isEqualTo(-5365.0)
            ->float(TestClass::sanitize(5365.0000000))
                ->isEqualTo(5365.0)
        ;
    }
}
