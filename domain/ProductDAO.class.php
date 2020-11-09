<?php

abstract class ProductDAO {
    
    /**
     * retourne la collection (un tableau simple) de tous les Product
     * (le tableau retourné peut être vide.)
     */
    abstract function findAll();
    
    /**
     * retourne l'instance de Product d'ID $searchedProductId
     * (ou null si le Product n'est pas trouvé)
     *
     * @param String $searchedProductId
     */
    abstract function findById($searchedProductId);
    
    /**
     * retourne l'instance de Product de nom $searchedProductName
     * (ou null si le Product n'est pas trouvé)
     *
     * @param String $searchedProductName
     */
    abstract function findByName($searchedProductName);
}

?>
