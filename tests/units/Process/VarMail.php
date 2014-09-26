<?php
/**
 * Test class for IsMail.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\VarMail as TestClass;

/**
 * Test class for IsMail.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class VarMail extends atoum
{
    /**
     * Contrôle ajout de dossiers dans l'include_path
     *
     * @return void
     */
    public function testCtrl()
    {
        $this
            ->boolean(TestClass::validate('aimbert@solire.fr'))
                ->isTrue()
            ->boolean(TestClass::validate('toto+test@free.fr'))
                ->isTrue()
            ->boolean(TestClass::validate('53-zert@club-marine53.com'))
                ->isTrue()
            ->boolean(TestClass::validate('aimbert@@solire.fr'))
                ->isFalse()
            ->boolean(TestClass::validate(''))
                ->isFalse()
        ;
    }
}
