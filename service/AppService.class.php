<?php
include_once dirname(__FILE__) . '/../domain/Ticket.class.php';
include_once dirname(__FILE__) . '/PDOTicketDAO.class.php';
include_once dirname(__FILE__) . '/Product.class.php';
include_once dirname(__FILE__) . '/FileProductDAO.class.php';

class AppService {
	private $_ticketDAO;
	private $_productDAO;

	function __construct() {
		$this->_ticketDAO = new PDOTicketDAO();
		$this->_productDAO = new FileProductDAO('app.csv');
	}

    function getAllApplisAsOptions() {
        $products = $this->getAppList();
        $result = '<option value="-1">--Autre--</option>';
        foreach ($products as $product) {
            $productId = $product->getID();
            $productName = $product->getName();
            $optionItem =<<<EOT
               <option>$productName</option>'
EOT;
            $result .= "$optionItem\n";
        }
        return $result;
    }

    function getAppList() {
        $products = $this->_productDAO->findAll();
        return $products;
    }

    static function printTicketAsTableRow($ticket, $tableRecordClass) {
		$applicationName = $ticket->getApplicationName();
		$priorityText = $ticket->getPriorityText();
		$type = $ticket->getType();
		$creationDate = $ticket->getCreationDate();
		$oneLiner = $ticket->getOneLiner();
		$detailedDescription = $ticket->getDetailedDescription();
		$str =<<<EOT
    <tr class="$tableRecordClass">
      <td class="center">$applicationName</td>
      <td class="center">$priorityText</td>
      <td class="center">$type</td>
      <td class="center">$creationDate</td>
      <td class="left">$oneLiner</td>
      <td class="left">$detailedDescription</td>
    </tr>
EOT;
		echo $str;
	}

	function saveTicket($ticket) {
		$this->_ticketDAO->save($ticket);
	}

	/**
	 * retourne la  collection (un tableau simple) de tous les tickets
	 * (le tableau retourné peut être vide.)
	 */
	function getAllTickets() {
		return $this->_ticketDAO->findAll();
	}

	/**
	 * retourne l'instance de Ticket d'ID $ticketId
	 */
	function findTicketById($ticketId) {
		return $this->_ticketDAO->findById($ticketId);
	}

    /**
     * retourne le mail associé au product de nom $productName
     */
    function getProductMailFromName($productName) {
        $product = $this->_productDAO->findByName($productName);
        if ($product == null)
            return null;
        return $product->getMail();
    }

    /**
     * envoie un mail au responsable de l'application relative au ticket $ticket
     */
    function sendMailForTicket($ticket) {
        $productName = $ticket->getApplicationName();
        $mail = $this->getProductMailFromName($productName);
        $subject = "YAHD : nouveau ticket pour $productName";
        $message = $ticket->getOneLiner();
        // Envoi du mail
        mail($mail, $subject, $message);
    }

    /**
     * retourne le nom associé au product d'ID $productId
     */
    function getProductName($productId) {
        $product = $this->_productDAO->findById($productId);
        if ($product == null)
            return null;
        return $product->getName();
    }
}
?>