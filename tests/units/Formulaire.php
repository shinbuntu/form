<?php
/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */

namespace Solire\Form\tests\unit;

use atoum;
use Solire\Form\Formulaire as TestClass;
use Solire\Form\FastConfig as FormulaireFastConfig;

/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license CC by-nc http://creativecommons.org/licenses/by-nc/3.0/fr/
 */
class Formulaire extends atoum
{

    /**
     * Renvoie une configuration simple
     *
     * @return \Slrfw\Formulaire\FastConfig
     */
    protected function getConfigTest()
    {
        $conf = new FormulaireFastConfig();
        $conf
            ->create('id')
                ->setRule('obligatoire', false)
                ->setRule('test', 'notEmpty|VarInt:>=0')
                ->setRule('erreur', 'Erreur interne')
            ->create('nom')
                ->setRule('obligatoire', true)
                ->setRule('test', ['VarString', 'length:>=2'])
                ->setRule('erreur', 'Erreur saisie')
        ;

        return $conf;
    }


    /**
     * Contrôle chargement de la configuration
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->exception(function () {
                $foo = new TestClass(null);
            })
                ->hasMessage('Configuration non valide')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->exception(function () {
                $foo = new TestClass([]);
            })
                ->hasMessage('Configuration non valide')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->object(new TestClass($this->getConfigTest()))
        ;
    }

    /**
     * Contrôle récupération des variable POST, GET, COOKIE
     *
     * @return void
     */
    public function testHttpDispatcher()
    {
        $this
            ->if($conf = $this->getConfigTest())
            ->and($conf->set('g', '__global', 'ordre'))
            ->and($_GET = ['nom' => 'fuuu', 'id' => 'HACK'])
            ->and($_POST = ['nom' => 'fuuuPOST', 'id' => 5])
            ->and($_COOKIE = ['nom' => 'fuuuCOOK', 'id' => 35])
            ->and($form = new TestClass($conf))
            ->array($form->run())
                ->isEqualTo(['nom' => 'fuuu'])
            ->if($conf->set('cpg', '__global', 'ordre'))
            ->array($form->run())
                ->isEqualTo(['nom' => 'fuuu'])
            ->if($conf->set('gp', '__global', 'ordre'))
            ->array($form->run())
                ->isEqualTo(['nom' => 'fuuuPOST', 'id' => 5])
            ->if($conf->set('gpc', '__global', 'ordre'))
            ->array($form->run())
                ->isEqualTo(['nom' => 'fuuuCOOK', 'id' => 35])
        ;
    }

    /**
     * Contrôle des erreurs lors de la récupération des champs
     *
     * @return void
     */
    public function testError()
    {
        $this
            ->if($conf = $this->getConfigTest())
            ->and($_GET = [
                'id' => -5,
                'nom' => 'N',
            ])
            ->and($form = new TestClass($conf))
            ->exception(function () use ($form) {
                $form->run();
            })
                ->hasMessage('Erreur saisie')
                ->isInstanceOf('\Slrfw\Exception\Lib')
            ->if($conf->set('\Slrfw\Exception\User', 'nom', 'exception'))
            ->exception(function () use ($form) {
                $form->run();
            })
                ->hasMessage('Erreur saisie')
                ->isInstanceOf('\Slrfw\Exception\User')
            ->if($conf->kill('nom', 'exception'))
            ->if($conf->set('\Slrfw\Exception\User', '__global', 'exception'))
            ->exception(function () use ($form) {
                $form->run();
            })
                ->hasMessage('Erreur saisie')
                ->isInstanceOf('\Slrfw\Exception\User')
        ;
    }

    /**
     * Fonctionnement des prefix
     *
     * @return void
     */
    public function testPrefix()
    {
        $this
            ->if($conf = $this->getConfigTest())
            ->and($conf->set('client_', '__global', 'prefix'))
            ->and($_GET = [
                'client_nom' => 'fuuu',
                'nom' => 'fuuulol',
            ])
            ->and($form = new TestClass($conf))
            ->array($form->run())
                ->isEqualTo(['nom' => 'fuuu'])
            ->array($form->getInputNamesList())
                ->isEqualTo(['client_id', 'client_nom'])
        ;
    }

    /**
     * Contrôles des differents getter de Formulaire
     *
     * @return void
     */
    public function testGetAndSet()
    {
        $this
            ->if($conf = $this->getConfigTest())
            ->and($conf->set('g', '__global', 'ordre'))
            ->and($_GET = ['nom' => 'fuuu', 'id' => '8'])
            ->and($form = new TestClass($conf))
            ->array($form->run())
                ->isEqualTo(['id' => 8, 'nom' => 'fuuu'])
            ->array($form->run('variableInutile'))
                ->isEqualTo(['id' => 8, 'nom' => 'fuuu'])
            ->array($form->getArray())
                ->isEqualTo(['id' => 8, 'nom' => 'fuuu'])
            ->variable($form->toto)
                ->isNull()
            ->string($form->id)
                ->isEqualTo(8)
            ->string($form->nom)
                ->isEqualTo('fuuu')
            ->boolean(isset($form->nom))
                ->isTrue()
            ->boolean(isset($form->nombre))
                ->isFalse()
            ->array($form->run(TestClass::FORMAT_LIST))
                ->isEqualTo(['8', 'fuuu'])
            ->array($form->getList())
                ->isEqualTo(['8', 'fuuu'])
            ->object($form->getConfig())
                ->isIdenticalTo($conf)
        ;
    }

    /**
     * Méthodes de configuration alternative
     *
     * @return void
     */
    public function testAlternativConfig()
    {
        $this
            ->if($conf = $this->getConfigTest())
            ->and($champ = new \Solire\Form\Champ('nom'))
            ->if($champ->setRule('renomme', 'toto'))
            ->and($conf->set($champ, 'nom'))
            ->and($form = new TestClass($conf))
            ->and($_GET = ['nom' => 'fuuu', 'id' => 'HACK'])
            ->array($form->run())
                ->isEqualTo(['toto' => 'fuuu'])
        ;
    }

    /**
     * Contrôle bon traitement des champs obligatoires
     *
     * @return void
     */
    public function testObligatoire()
    {
        $this
            ->if($conf = $this->getConfigTest())
            ->and($conf->set('g', '__global', 'ordre'))
            ->and($_GET = ['nom' => 'fuuu', 'id' => 'HACK'])
            ->and($form = new TestClass($conf))
            ->array($form->run())
                ->isEqualTo(['nom' => 'fuuu'])
            ->if($conf->set(true, 'id', 'obligatoire'))
            ->exception(function () use ($form) {
                $form->run();
            })
                ->hasMessage('Erreur interne')
                ->isInstanceOf('\Slrfw\Exception\Lib')
        ;
    }
}
