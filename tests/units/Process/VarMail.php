<?php
/**
 * Test class for IsMail.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Solire\Form\Process\tests\unit;

use atoum;
use Solire\Form\Process\VarMail as TestecClass;

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
            ->boolean(TestecClass::validate('aimbert@solire.fr'))
                ->isTrue()
            ->boolean(TestecClass::validate('toto+test@free.fr'))
                ->isTrue()
            ->boolean(TestecClass::validate('53-zert@club-marine53.com'))
                ->isTrue()
            ->boolean(TestecClass::validate('aimbert@@solire.fr'))
                ->isFalse()
            ->boolean(TestecClass::validate(''))
                ->isFalse()
        ;
    }
}
