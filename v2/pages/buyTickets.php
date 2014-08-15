<?php
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/tickettypehandler.php';
require_once 'handlers/eventhandler.php';
require_once 'session.php';

class Page {
	public function render() {
		$user = Session::getCurrentUser();
		if( StoreSessionHandler::hasStoreSession( $user ) )
		{
			echo "Det virker som om du har forlatt et kjøp! Kontakt support.";
		}
		else
		{
			$this->renderFirstStep();
		}
	}
	
	public function renderTutorial() {
		echo '<h1>Slik kjøper du billett</h1>';
		echo '<table width="100%">';
			echo '<tr>';
				echo '<td>';
					echo '<h3>Steg 1.</h3>';
					echo '<p>Velg antall billetter du vil kjøpe</p>';
				echo '</td>';
				echo '<td>';
					echo '<h3>Steg 2.</h3>';
					echo '<p>Betal for billetten(e)</p>';
				echo '</td>';
				echo '<td>';
					echo '<h3>Steg 3.</h3>';
					echo '<p>Verifiser detaljer og godkjenn betalingen!</p>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	}
	public function renderFirstStep() {
		$currentEvent = EventHandler::getCurrentEvent();
		$type = $currentEvent->getTicketType();
		echo '<h2>';
			echo 'Kjøper billett for Infected ';
			echo $currentEvent->getTheme();
			echo ' ( ';
			echo date("d", $currentEvent->getStartTime()) . 
	                    '. - ' . 
	                    date("d", $currentEvent->getEndTime()) . 
	                    '. ' . 
	                    date("F", $currentEvent->getStartTime()) . 
	                    '.';
	        echo ' )';
		echo '</h2>';
		echo '<script src="scripts/buyTickets.js"></script>';
		echo '<script>';
			echo 'var ticketPrice = ' . $type->getPrice() . ';';
			echo 'var ticketType = ' . $type->getId() . ';';
		echo '</script>';
		echo '<form action="" id="buyTicketForm">';
			echo '<input type="hidden" name="ticketType" value="' . $type->getId() . '" />';
			echo '<table>';
				echo '<tr>';
					echo '<center>';
						echo '<td>';
							echo 'Bilettnavn';
						echo '</td>';
						echo '<td>';
							echo 'Pris';
						echo '</td>';
						echo '<td>';
							echo 'Bestill antall';
						echo '</td>';
						echo '<td>';
							echo 'Antall ledige';
						echo '</td>';
						echo '<td>';
							echo 'Total';
						echo '</td>';
						echo '<td>';
						echo '</td>';
					echo '</center>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo '<h3>';
							echo $type->getHumanName();
						echo '</h3>';
					echo '</td>';
					echo '<td>';
						echo $type->getPrice();
					echo '</td>';
					echo '<td>';
						$ticketsLeft = $currentEvent->getAvailableTickets();
						echo '<input id="ticketAmount" type="number" name="amount" value="1" min="1" max="' . $ticketsLeft . '"/>';
					echo '</td>';
					echo '<td>';
						echo $ticketsLeft . '/' . $currentEvent->getParticipants();
					echo '</td>';
					echo '<td>';
						echo '<span id="totalPrice">' . $type->getPrice() . '</span>';
					echo '</td>';
					echo '<td>';
						echo '<input type="submit" value="Kjøp" />';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		echo '</form>';
	}
}
?>