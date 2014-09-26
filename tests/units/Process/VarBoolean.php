<?php
/**
 * Test class for IsBoolean.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\VarBoolean as TestClass;

/**
 * Test class for IsBoolean.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class VarBoolean extends atoum
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
