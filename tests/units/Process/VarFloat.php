<?php
/**
 * Test class for VarFloat
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\VarFloat as TestClass;

/**
 * Test class for VarFloat
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
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
}
