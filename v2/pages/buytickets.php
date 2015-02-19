<?php
require_once 'session.php';
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/tickettypehandler.php';
require_once 'handlers/eventhandler.php';
require_once 'utils/dateutils.php';

class TicketPage {
	public function render() {
		$user = Session::getCurrentUser();
		
		if (StoreSessionHandler::hasStoreSession($user)) {
			$session = StoreSessionHandler::getStoreSessionByUser($user);
			StoreSessionHandler::deleteStoreSession($session);
		}

		$this->renderFirstStep();
	}
	
	public function renderTutorial() {
		echo '<h1 style="margin-bottom:0px;">Slik kjøper du billett</h1>';
		echo '<center>';
			echo '<table width="100%">';
				echo '<tr>';
					echo '<td style="text-align:center">';
						echo '<h3 style="margin: 0px">1. Velg antall</h3>';
						echo '<img src="images/tickets.jpg" />';
					echo '</td>';
					echo '<td style="text-align:center">';
						echo '<h3 style="margin: 0px">2. Godkjenn regler og rettningslinjer</h3>';
						echo '<img src="images/rules.jpg" />';
					echo '</td>';
					echo '<td style="text-align:center">';
						echo '<h3 style="margin: 0px">3. Bekreft / Betal</h3>';
						echo '<img src="images/confirm.jpg" />';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		echo '</center>';
		
		echo '<div id="divInstruks1">';
			echo '<p>Når du har kjøpt billett får du den/de opp på siden "Mine Billetter". Du velger plass etter at du har kjøpt billetten på "Plassreservering".</p>';
			
			
			echo '<p>Alle som skal på Infected må ha en bruker med en tilknyttet billett.';
	
			echo '<br><br>';
			echo '<p>Det er mulig å kjøpe billetter på vegne av andre. Kjøp billetten(e) og overfør eierskap på siden "Mine billetter".</p>';
		echo'</div>';
	}
	public function renderFirstStep() {
		$currentEvent = EventHandler::getCurrentEvent();
		$user = Session::getCurrentUser();
		
		if($currentEvent->isBookingTime()) {
			$type = $currentEvent->getTicketType();
			
			echo '<h2>';
				echo 'Kjøper billett for Infected ' . $currentEvent->getTheme() . ' (';
				echo date('d', $currentEvent->getStartTime()) . '. - ' . date('d', $currentEvent->getEndTime()) . '. ' . DateUtils::getMonthFromInt(date('m', $currentEvent->getStartTime())) . '.)';
			echo '</h2>';
			echo '<script src="scripts/buyTickets.js"></script>';
			echo '<script>';
				echo 'var ticketPrice = ' . $type->getPriceForUser($user). ';';
			echo '</script>';
			echo '<form action="index.php?page=rules" id="buyTicketForm" method="post">';
				echo '<input type="hidden" name="ticketType" value="' . $type->getId() . '" />';
				echo '<table>';
					echo '<tr>';
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
					echo '</tr>';
					echo '<tr>';
						echo '<td>';
							echo '<b>';
								echo $type->getHumanName();
							echo '</b>';
						echo '</td>';
						echo '<td>';
							echo $type->getPriceForUser($user) . ',-';
						echo '</td>';
						echo '<td>';
							$ticketsLeft = $currentEvent->getAvailableTickets();
							echo '<input id="ticketAmount" type="number" name="ticketAmount" value="1" min="1" max="' . $ticketsLeft . '">';
						echo '</td>';
						echo '<td>';
							echo $ticketsLeft . '/' . $currentEvent->getParticipants();
						echo '</td>';
						echo '<td>';
							echo '<span id="totalPrice">' . $type->getPriceForUser($user) . ',-</span>';
						echo '</td>';
						echo '<td>';
							echo '<input type="submit" value="Neste" />';
						echo '</td>';
					echo '</tr>';
				echo '</table>';
			echo '</form>';
		} else {
			echo '<h1>Billettsalget har ikke åpnet enda</h1>';
			echo '<p>Billettsalget åpner ' . DateUtils::getDayFromInt(date('w', $currentEvent->getBookingTime())) . ' den ' . date('d', $currentEvent->getBookingTime()) . '. ' . DateUtils::getMonthFromInt(date('m', $currentEvent->getBookingTime())) . ' klokken ' . date('H:i', $currentEvent->getBookingTime()) . '.</p>';
		}
	}
}
?>