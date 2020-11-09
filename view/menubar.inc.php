<font size="-1">
<?php 
  // définition de la barre de menus
  if ( !isset($menuBarTitles) ) {
    $menuBarTitles[0] = "Page d'accueil";  $menuBarLinks[0] = 'view/index.php';
    $menuBarTitles[] = 'Créer un ticket';  $menuBarLinks[] = 'view/editTicket.php';
    $menuBarTitles[] = 'Voir tous les tickets';  $menuBarLinks[] = 'view/showAllTickets.php';
  }
  $menuItemCounts = count($menuBarTitles);
  
  // affichage de la barre de menus
  for ( $i = 0; $i < $menuItemCounts ; $i++ )
  {
    if ( isset($pageId) && $pageId == $menuBarTitles[$i] )
      // ne pas afficher un lien pour la page courante 
      printf( "<strong>%s</strong>", $menuBarTitles[$i]);
    else 
      // afficher un lien vers les autres pages
      printf("<a href=\"%s\">%s</a>", $menuBarLinks[$i], $menuBarTitles[$i]);
    if ( $i + 1 < $menuItemCounts )
      echo " | ";
  }
?>
</font>