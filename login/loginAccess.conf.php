<?php
// Changer ces 2 lignes pour utiliser un validateur de login diff�rent
include_once dirname(__FILE__) . '/AcceptAllExceptZZZLoginController.class.php';
$loginControl = new AcceptAllExceptZZZLoginController();
?>
