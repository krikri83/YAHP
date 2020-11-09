<?php
class Product {
	private $id;
	private $name;
	private $mail;

	function __construct($name, $mail, $id = -1) {
		$this->id = $id;
		$this->name = $name;
		$this->mail = $mail;
	}

	function getID() {
		return $this->id;
	}
	function getName() {
		return $this->name;
	}
	
	function getMail() {
		return $this->mail;
	}
	function setMail($mail) {
		$this->mail = $mail;
	}
	
	/**
	 * check a mail address
	 * 
	 * check the correctness of length, domain and contents
	 * of a mail address  
	 * 
	 * @param string $mail mail address to check
	 *    if this $mail parameter is '', check the mail 
	 *    atribute of the current object
	 * @return boolean true if $mail OK, false else
	 */
	function checkMail($mail = '') {
		if ( $mail == '' ) 
			$mail = $this->mail;
		// 1. tests sur longueur
		$l = strlen($mail);
		if ( $l <= 10 ) return false;
		if ( $l >= 35 ) return false;
		// 2. présence d'un arrobase
		$array = explode('@', $mail);
		if ( count($array) != 2 ) return false;
		// 3. contrôle sur le domaine
		list($name, $domain) = explode('@', $mail);
		$array = explode('.', $domain);
		$country = $array[count($array)-1];
		if ( $country != 'fr' ) return false;
 		// 4. la partie nom doit être alphanumérique
		if ( !preg_match('/^[a-zA-Z.-]+$/', $name) ) return false;
		return true;
	}
}
?>
