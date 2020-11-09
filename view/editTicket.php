<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

  <meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
  <link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen"/>
  <title>YAHD - Saisie Anomalie</title>
</head>

<body>
<?php 
$pageId = 'CrÈer un ticket';
include 'header.inc.php';
include 'login/loginAccess.inc.php'; 



include 'AppService.class.php';
$appService = new AppService();
$allApplisAsOptions = $appService->getAllApplisAsOptions();

include 'editTicketForm.php';
?>
<a href="index.php" id="home">Page d'accueil</a><br/>
<a href="?logout=1" id="deconnexion">Se d√©connecter</a>
<?php include 'footer.inc.php'; ?>
</body>
</html>
