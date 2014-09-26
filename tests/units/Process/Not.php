<?php
/**
 * Test class for Not
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\Not as TestClass;

/**
 * Test class for Not
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class Not extends atoum
{
    /**
     * Contrôle validations de valeurs simple
     *
     * @return void
     */
    public function testCtrl()
    {
        $this
            ->boolean(TestClass::validate(5, '5'))
                ->isFalse()
            ->boolean(TestClass::validate(5, 5))
                ->isFalse()
            ->boolean(TestClass::validate('allo', 8))
                ->isTrue()
        ;
    }
}
