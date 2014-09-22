<?php
/**
 * Test class for IsInt.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace tests\unit\Sowork\Formulaire\Validate;

use atoum;
use Sowork\Formulaire\Validate\IsInt as TestClass;

/**
 * Test class for IsInt.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class IsInt extends atoum
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
            ->boolean(TestClass::validate(+15))
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
                ->isFalse()
            ->boolean(TestClass::validate('a523'))
                ->isFalse()
            ->boolean(TestClass::validate('0.6'))
                ->isFalse()
            ->boolean(TestClass::validate('-5648.5'))
                ->isFalse()
            ->boolean(TestClass::validate('-564d85'))
                ->isFalse()
        ;
    }

    /**
     * Contrôle utilisation de bornes
     *
     * @return void
     */
    public function testBornes()
    {
        $this
            ->boolean(TestClass::validate(-5, '>=0'))
                ->isFalse()
            ->boolean(TestClass::validate(0, '>=0'))
                ->isTrue()
            ->boolean(TestClass::validate(10, '>=0'))
                ->isTrue()
            ->boolean(TestClass::validate(10, '>=0&<=20'))
                ->isTrue()
            ->boolean(TestClass::validate(10, '>=0&<=5'))
                ->isFalse()
        ;
    }
}
