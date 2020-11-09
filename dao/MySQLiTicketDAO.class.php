<?php
include_once 'Ticket.class.php';
include_once 'TicketDAO.class.php';

class MySQLiTicketDAO extends TicketDAO {
	private $mysqli;
	private $TABLE_NAME = 'TICKET';
	private $COLUMN_NAMES = ' ticketID , applicationName , login , priority , type , creationDate , oneLiner , detailedDescription , attachmentName ';

	function __construct() {
		include 'mysql.conf.php';
		$this->mysqli = @mysqli_connect ($g_Host, $g_User, $g_Password, $g_DbName);
		if ( $this->mysqli == null ) {
			echo "Echec de la connexion: ".mysqli_connect_error()."<br/>";
			exit();
		}
	}

	function __destruct() {
		$this->mysqli->close();
	}

	/**
	 * retourne la  collection (un tableau simple) de tous les tickets
	 * (le tableau retourné peut être vide.)
	 */
	function findAll() {
		$result = array ();
		$query = "SELECT $this->COLUMN_NAMES FROM $this->TABLE_NAME";
		$qresult = $this->mysqli->query($query);
		if ( !$qresult ) {
			echo "Error calling findAll() : " . $this->mysqli->error;
			return $result;
		}
		while ( $row = $qresult->fetch_array() ) {
			list ($ticketID, $applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName) = $row;
			$newTicket = new Ticket($applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName, $ticketID);
			$result[] = $newTicket; // ajoute le nouveau ticket au tableau
		}
		$qresult->close();
		return $result;
	}

	/**
	 * retourne l'instance de Ticket d'ID $searchedTicketId
	 * (ou null si le ticket n'est pas trouvé)
	 */
	function findById($searchedTicketId) {
		$result = null;
		$query = "SELECT $this->COLUMN_NAMES FROM $this->TABLE_NAME WHERE ticketID = '" . $searchedTicketId . "'";
		$qresult = $this->mysqli->query($query);
		if ( $this->mysqli->errno != 0 ) echo "Error calling findById() : " . $this->mysqli->error;
		$row = $qresult->fetch_array();
		if ( $row ) {
			list ($ticketID, $applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName) = $row;
			$newTicket = new Ticket($applicationName, $login, $priority, $type, $creationDate, $oneLiner, $detailedDescription, $attachmentName, $ticketID);
			$result = $newTicket;
		}
		$qresult->close();
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
		INSERT INTO $this->TABLE_NAME ( applicationName , login , priority , type , creationDate , oneLiner , detailedDescription , attachmentName ) 
		VALUES ( '$applicationName', '$login', '$priority', '$type', '$creationDate', '$oneLiner', '$detailedDescription', '$attachmentName') ;
EOT;
		$result = $this->mysqli->query($insertquery);
		if ( $this->mysqli->errno != 0 ) echo "Error calling insert() : " . $this->mysqli->error;
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
		$updatequery =<<<EOT
		UPDATE $this->TABLE_NAME SET applicationName = '$applicationName', login = '$login', priority = $priority, type = '$type' , oneLiner = '$oneLiner', detailedDescription =  '$detailedDescription' WHERE ticketID = '$ticketID';
EOT;
		$result = $this->mysqli->query($updatequery);
		if ( $this->mysqli->errno != 0 ) echo "Error calling update() : " . $this->mysqli->error;
	}

	function deleteAll() {
		$deletequery = 'DELETE FROM ' . $this->TABLE_NAME;
		$result = $this->mysqli->query($deletequery);
		if ( $this->mysqli->errno != 0 ) echo "Error calling delete() : " . $this->mysqli->error;
	}
}
?>