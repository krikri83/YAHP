<?php
include_once dirname(__FILE__) . '/../domain/Ticket.class.php';
include_once 'TicketDAO.class.php';

class PDOTicketDAO extends TicketDAO {
	private $_pdo;
	private $TABLE_NAME = 'TICKET';
	private $COLUMN_NAMES = ' ticketID , applicationName , login , priority , type , creationDate , oneLiner , detailedDescription , attachmentName ';

	function __construct() {
		include 'pdo.conf.php';
		try {
		    $this->_pdo = new PDO ($connectionString, $g_User, $g_Password);
		}
		catch ( PDOException $e ) {
		    echo "Echec de la connexion: ".$e->getMessage()."<br/>";
			die();
		}
	}

	function __destruct() {
		$this->_pdo = null;
	}

	/**
	 * retourne la  collection (un tableau simple) de tous les tickets
	 * (le tableau retourné peut être vide.)
	 */
	function findAll() {
		$result = array ();
		$query = "SELECT $this->COLUMN_NAMES FROM $this->TABLE_NAME";
		$stmt = $this->_pdo->prepare($query);
		if ( !$stmt->execute() ) {
		    echo "Error calling findAll() : ";
		    print_r($stmt->errorInfo());
			return $result;
		}
		while ( $row = $stmt->fetch() ) {
			list ($ticketID, $applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName) = $row;
			$newTicket = new Ticket($applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName, $ticketID);
			$result[] = $newTicket; // ajoute le nouveau ticket au tableau
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	/**
	 * retourne l'instance de Ticket d'ID $searchedTicketId
	 * (ou null si le ticket n'est pas trouvé)
	 */
	function findById($searchedTicketId) {
		$result = null;
		$query = "SELECT $this->COLUMN_NAMES FROM $this->TABLE_NAME WHERE ticketID = ?";
		$stmt = $this->_pdo->prepare($query);
		$stmt->bindParam(1, $searchedTicketId);
		if ( !$stmt->execute() ) {
		    echo "Error calling findById() : ";
		    print_r($stmt->errorInfo());
		}
		$row = $stmt->fetch();
		if ( $row ) {
			list ($ticketID, $applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName) = $row;
			$newTicket = new Ticket($applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName, $ticketID);
			$result = $newTicket;
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	/**
	 * sauve $ticket dans la base
	 */
	function save(Ticket $ticket) {
		if ( $ticket->getTicketID() == -1 )
			return $this->insert($ticket);
		else
			return $this->update($ticket);
	}

	/**
	 * insère $ticket comme un nouvel enregistrement
	 */
	function insert(Ticket $ticket) {
		$applicationName = $ticket->getApplicationName();
		$login = $ticket->getLogin();
		$priority = $ticket->getPriority();
		$type = $ticket->getType();
		$creationDate = $ticket->getCreationDate();
		// protéger les caractères guillemets
		$oneLiner = addslashes($ticket->getOneLiner());
		$detailedDescription = addslashes($ticket->getDetailedDescription());
		$attachmentName = $ticket->getAttachmentName();
		$insertquery =<<<EOT
		INSERT INTO $this->TABLE_NAME ( applicationName , login , priority , type , creationDate , 
                  oneLiner , detailedDescription , attachmentName ) 
		VALUES ( :applicationName, :login, :priority, :type, :creationDate, 
                  :oneLiner, :detailedDescription, :attachmentName) ;
EOT;
		$stmt = $this->_pdo->prepare($insertquery);
		$stmt->bindParam(':applicationName', $applicationName);
		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':priority', $priority);
		$stmt->bindParam(':type', $type);
		$stmt->bindParam(':creationDate', $creationDate);
		$stmt->bindParam(':oneLiner', $oneLiner);
		$stmt->bindParam(':detailedDescription', $detailedDescription);
		$stmt->bindParam(':attachmentName', $attachmentName);
		if ( !$stmt->execute() ) {
		    echo "Error calling insert() : ";
		    print_r($stmt->errorInfo());
		}
		$stmt->closeCursor();
	}

	/**
	 * met à jour l'enregistrement d'id $ticket->ticketID à partir de $ticket
	 */
	function update(Ticket $ticket) {
		$ticketID = $ticket->getTicketID();
		$applicationName = $ticket->getApplicationName();
		$login = $ticket->getLogin();
		$priority = $ticket->getPriority();
		$type = $ticket->getType();
		$creationDate = $ticket->getCreationDate();
		// protéger les caractères guillemets
		$oneLiner = addslashes($ticket->getOneLiner());
		$detailedDescription = addslashes($ticket->getDetailedDescription());
		$attachmentName = $ticket->getAttachmentName();
		$updatequery =<<<EOT
		UPDATE $this->TABLE_NAME SET applicationName = :applicationName, login = :login, 
            priority = :priority, type = :type , creationDate = :creationDate, oneLiner = :oneLiner, 
            detailedDescription = :detailedDescription, attachmentName = :attachmentName
            WHERE ticketID = :ticketID;
EOT;
		$stmt = $this->_pdo->prepare($updatequery);
		$stmt->bindParam(':applicationName', $applicationName);
		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':priority', $priority);
		$stmt->bindParam(':type', $type);
		$stmt->bindParam(':creationDate', $creationDate);
		$stmt->bindParam(':oneLiner', $oneLiner);
		$stmt->bindParam(':detailedDescription', $detailedDescription);
		$stmt->bindParam(':attachmentName', $attachmentName);
		$stmt->bindParam(':ticketID', $ticketID);
		if ( !$stmt->execute() ) {
		    echo "Error calling insert() : ";
		    print_r($stmt->errorInfo());
		}
		$stmt->closeCursor();
	}

	function deleteAll() {
		$deletequery = 'DELETE FROM ' . $this->TABLE_NAME;
		$this->_pdo->exec($deletequery);
		if ( $this->_pdo->errorCode() != 0 ) {
		    echo "Error calling delete() : " ;
		    print_r($stmt->errorInfo());
		}
	}
}
?>