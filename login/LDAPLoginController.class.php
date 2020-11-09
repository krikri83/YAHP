<?php
include_once ('AbstractLoginController.class.php');
include_once ('ldap.cnam.conf.php'); // définit $GLOBALS['LDAP_HOST']

class LDAPLoginController extends AbstractLoginController {

	function isValidLogin($login) {
		return true; // test impossible avec LDAP!?
	}

	function isValidPassword($login, $password, & $errorMessage) {
		return $this->search($login, $password, $errorMessage);
	}

	/* private */
	function search($user, $pwd, & $errorMessage) {
		$errorMessage = '';
		$ds = ldap_connect($GLOBALS['LDAP_HOST']);
		if ($ds) {
			$ldap_base = "ou=People,o=personnel,dc=cnam,dc=fr";
			$dn = "uid=" . $user . "," . $ldap_base;
			$r = @ ldap_bind($ds, $dn, $pwd);
			ldap_close($ds);
			return $r;
		} else {
			$errorMessage = "Impossible de se connecter au serveur LDAP {$GLOBALS['LDAP_HOST']}";
			die($errorMessage);
		}
		return false;
	}
}
?>
