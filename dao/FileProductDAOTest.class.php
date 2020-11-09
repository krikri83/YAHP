<?php
if ( is_dir('../tests/simpletest') ) {
  require_once (dirname(__FILE__) . '/../tests/simpletest/unit_tester.php');
  require_once (dirname(__FILE__) . '/../tests/simpletest/reporter.php');
}
else {
  require_once ('simpletest/unit_tester.php');
  require_once ('simpletest/reporter.php');
}
require_once ('FileProductDAO.class.php');

class FileProductDAOTest extends UnitTestCase {
	private $dao; // fixture
	function setUp() {
		$this->dao = new FileProductDAO('app_test.csv');
	}
	function tearDown() {
		$this->dao = null;
	}
	function testFindAll() {
		$products = $this->dao->findAll();
		$product = $products[2];
		$this->assertEqual(3, $product->getID());
		$this->assertEqual('moi@cnam.fr', $product->getMail());
	}
	function testFindById() {
		$product = $this->dao->findById('3');
		$this->assertEqual(3, $product->getID());
		$this->assertEqual('moi@cnam.fr', $product->getMail());
	}
	function testFindByName() {
		$product = $this->dao->findByName('Paye');
		$this->assertEqual('Paye', $product->getName());
		$this->assertEqual(1, $product->getID());
		$this->assertEqual('paye@cnam.fr', $product->getMail());
		$product = $this->dao->findByName('Inscriptions');
		$this->assertEqual('Inscriptions', $product->getName());
		$this->assertEqual(2, $product->getID());
		$this->assertEqual('inscriptions@cnam.fr', $product->getMail());
	}
}
if (!defined('RUNNER')) {
	define('RUNNER', true);
	$test = new FileProductDAOTest();
	$test->run(new TextReporter());
}

?>
