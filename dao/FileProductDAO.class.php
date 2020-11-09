<?php
include_once 'Product.class.php';

class FileProductDAO {

	private $filePath; // chemin du fichier utilisé pour la persistance des products
	private $nextProductID; // ID du prochain product créé

	function __construct($filePath = 'app.csv') {
		$this->filePath = $filePath;
		$lastProductID = $this->getLastID();
		$this->nextProductID = $lastProductID +1;
	}

	/**
	 * retourne la  collection (un tableau simple) de tous les products
	 * (le tableau retourné peut être vide.)
	 */
	function findAll() {
		$result = array ();
		$fd = fopen($this->filePath, 'r'); // ouverture du fichier en lecture
		if (!$fd)
			return $result;
		while ($line = fgets($fd)) {
			list ($productID, $productName, $mail) = explode(';', $line);
			// supprime les espaces initiaux et finals
			$productID = trim($productID);
			$productName = trim($productName);
			$mail = trim($mail);
			$newProduct = new Product($productName, $mail, $productID);
			$result[] = $newProduct; // ajoute le nouveau product au tableau
		}
		fclose($fd); // fermeture du fichier
		return $result;
	}

	/**
	 * retourne l'instance de Product d'ID $searchedProductId
	 * (ou null si le product n'est pas trouvé)
	 */
	function findById($searchedProductId) {
		$result = null;
		$fd = fopen($this->filePath, 'r'); // ouverture du fichier en lecture
		if (!$fd)
			return $result;
		while ($line = fgets($fd)) {
			list ($productID, $productName, $mail) = explode(';', $line);
			// supprime les espaces initiaux et finals
			$productID = trim($productID);
			$productName = trim($productName);
			$mail = trim($mail);
			if ($productID == $searchedProductId) {
				$newProduct = new Product($productName, $mail, $productID);
				$result = $newProduct;
				break;
			}
		}
		fclose($fd); // fermeture du fichier
		return $result;
	}

	/**
	 * retourne l'instance de Product de nom $searchedProductName
	 * (ou null si le product n'est pas trouvé)
	 */
	function findByName($searchedProductName) {
		$result = null;
		$fd = fopen($this->filePath, 'r'); // ouverture du fichier en lecture
		if (!$fd)
			return $result;
		while ($line = fgets($fd)) {
			list ($productID, $productName, $mail) = explode(';', $line);
			// supprime les espaces initiaux et finals
			$productID = trim($productID);
			$productName = trim($productName);
			$mail = trim($mail);
			if ($productName == $searchedProductName) {
				$newProduct = new Product($productName, $mail, $productID);
				$result = $newProduct;
				break;
			}
		}
		fclose($fd); // fermeture du fichier
		return $result;
	}
	
	function save($product) {
		$this->initProductID($product);
		$line = implode(';', array ($product->productID, $product->applicationName, $product->mail));
		$fd = fopen($this->filePath, 'a+'); // ouverture du fichier en écriture 'append'
		if (!$fd)
			return;
		$line .= "\n"; // concaténation d'un saut de ligne
		fputs($fd, $line); // écriture de la ligne en fin de fichier
		fclose($fd); // fermeture du fichier
	}

	function initProductID($product) {
		if ($product->getProductID() != -1)
			return;
		// sinon on initialise l'ID 
		$product->setProductID($this->nextProductID);
	}

	function getLastID() {
		return $this->getNumberOfLines($this->filePath);
	}

	function getNumberOfLines($file) {
		$fd = fopen($this->filePath, 'r'); // ouverture du fichier en lecture
		if (!$fd)
			return -1;
		$result = 0;
		while ($line = fgets($fd)) {
			$result++;
		}
		fclose($fd); // fermeture du fichier
		return $result;
	}
}
?>