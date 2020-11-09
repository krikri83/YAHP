<?php
if ( is_dir('../tests/simpletest') ) {
  require_once (dirname(__FILE__) . '/../tests/simpletest/unit_tester.php');
  require_once (dirname(__FILE__) . '/../tests/simpletest/reporter.php');
}
else {
  require_once ('simpletest/unit_tester.php');
  require_once ('simpletest/reporter.php');
}
require_once ('Product.class.php');

class ProductTest extends UnitTestCase {
    var $product; // fixture
    function setUp() {
        $this->product = new Product('Paye', 'paye@cnam.fr');
    }
    function tearDown() {
        $this->product = null;
    }
    function testGetMail() {
        $this->assertEqual('paye@cnam.fr', $this->product->getMail());
    }
    function testSetMail() {
        $newMail = 'paye2@cnam.fr';
        $this->product->setMail($newMail);
        $this->assertEqual($newMail, $this->product->getMail());
    }    

    function testCheckMailWithInvalidLength() {
    	$mail = 'x@x.fr';
        $b = $this->product->checkMail($mail);
        $this->assertEqual(false, $b, "$mail est une adresse trop courte => échec");
        $mail = 'engagelejeuquejelegagne@duel-de-mots.fr';
        $b = $this->product->checkMail($mail);
        $this->assertFalse($b, "$mail est une adresse trop longue => échec");
    }
    function testCheckMailWithoutArrobas() {
        $b = $this->product->checkMail('nobody.nobody');
        $this->assertFalse($b, "Adresse sans @ => échec");
    }
    function testCheckMailDomain() {
        $b = $this->product->checkMail('nobody@cnam.fr');
        $this->assertTrue($b, "Adresse du CNAM => succès");
        $b = $this->product->checkMail('nobody@x.com');
        $this->assertFalse($b, "Adresse pas dans le domaine .fr => échec");
    }
    function testCheckMailName() {
        $b = $this->product->checkMail('nobody2@cnam.fr');
        $this->assertFalse($b, "Chiffre interdit dans le nom");
        $b = $this->product->checkMail('A#!!?@cnam.fr');
        $this->assertFalse($b, "Caractères non alphanumériques interdits dans le nom");
        $b = $this->product->checkMail('bernard.kouchner@cnam.fr');
        $this->assertTrue($b, "Le point est autorisé dans la partie nom");
    }
}
if (!defined('RUNNER')) {
    define('RUNNER', true);
    $test = new ProductTest();
    $test->run(new TextReporter());
}

?>
