<?php
/**
 * Test class for IsBoolean.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace tests\unit\Sowork\Formulaire\Validate;

use atoum;
use Sowork\Formulaire\Validate\IsBoolean as TestClass;

/**
 * Test class for IsBoolean.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class IsBoolean extends atoum
{
    /**
     * Contrôle ajout de dossiers dans l'include_path
     *
     * @return void
     */
    public function testCtrl()
    {
        $this
            ->boolean(TestClass::validate(true))
                ->isTrue()
            ->boolean(TestClass::validate(false))
                ->isTrue()
            ->boolean(TestClass::validate(1))
                ->isTrue()
            ->boolean(TestClass::validate(0))
                ->isTrue()
            ->boolean(TestClass::validate('true'))
                ->isTrue()
            ->boolean(TestClass::validate('false'))
                ->isTrue()
            ->boolean(TestClass::validate('on'))
                ->isTrue()
            ->boolean(TestClass::validate('off'))
                ->isTrue()
            ->boolean(TestClass::validate('a'))
                ->isFalse()
            ->boolean(TestClass::validate(58962))
                ->isFalse()
        ;
    }
}
