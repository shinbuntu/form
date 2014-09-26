<?php
/**
 * Test class for Length
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\Length as TestClass;

/**
 * Test class for Length
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class Length extends atoum
{
    /**
     * Contrôle validations de valeurs simple
     *
     * @return void
     */
    public function testCtrl()
    {
        $this
            ->boolean(TestClass::validate(5, '>=1'))
                ->isTrue()
            ->boolean(TestClass::validate('01 42 53 68 95', '>=10'))
                ->isTrue()
            ->boolean(TestClass::validate('01 42 53 68 95', '>=30'))
                ->isFalse()
            ->boolean(TestClass::validate('Allo', '<4'))
                ->isFalse()
            ->boolean(TestClass::validate('Allo', '<40'))
                ->isTrue()
            ->boolean(TestClass::validate('Allo', '<=4'))
                ->isTrue()
            ->boolean(TestClass::validate('Allo', '=4'))
                ->isTrue()
            ->boolean(TestClass::validate('Allo', '=8'))
                ->isFalse()
            ->boolean(TestClass::validate('AlloPlus', '<=4'))
                ->isFalse()
            ->boolean(TestClass::validate('AlloPlus', '<=4'))
                ->isFalse()
            ->boolean(TestClass::validate('AlloPlus', '>4'))
                ->isTrue()
            ->boolean(TestClass::validate('AlloPlus', '>50'))
                ->isFalse()
        ;
    }
}
