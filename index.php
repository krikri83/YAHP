<?php
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Accueil</title>
  <link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen">
</head>

<body>
<?php include 'login/loginAccess.inc.php'; 
$pageId = "Page d'accueil";


include dirname(__FILE__) . '/view/header.inc.php';
$userId = '';
if ( isset($_SESSION['userId']) )  $userId = $_SESSION['userId'];
?>
 <CENTER>
<h1>Bienvenue <?php echo $userId; ?>!</h1></br></br></br>
    </CENTER>


<?php
if ( !isset($_SESSION['userId']) ) {
?>
    (Attention, certaines fonctionnalit�s ne sont accessibles qu'apr�s s'�tre authentifi�.)
<?php
}
include dirname(__FILE__) . '/view/footer.inc.php';
?>
</body>
</html>