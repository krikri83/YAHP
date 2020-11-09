<?php
include_once 'Ticket.class.php';

abstract class TicketDAO {

	/**
	 * retourne la collection (un tableau simple) de tous les tickets
	 * (le tableau retourné peut être vide.)
	 */
	abstract function findAll();

	/**
	 * retourne l'instance de Ticket d'ID $searchedTicketId
	 * (ou null si le ticket n'est pas trouvé)
	 *
	 * @param String $searchedTicketId
	 */
	abstract function findById($searchedTicketId);

	/**
	 * sauvegarde le ticket passé en argument sur le support de persistence
	 *
	 * @param Ticket $ticket
	 */
	abstract function save(Ticket $ticket);
}
?>