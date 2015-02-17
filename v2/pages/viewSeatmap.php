<?php
require_once 'handlers/eventhandler.php';
require_once 'session.php';
class TicketPage {
	public function render() {
		$currentEvent = EventHandler::getCurrentEvent();
		$seatmap = $currentEvent->getSeatmap();
		
		echo '<script src="scripts/seatmap.js"></script>';
		echo '<script src="../api/scripts/seatmapRenderer.js"></script>';
		echo '<script>';
			echo 'var seatmapId = ' . $seatmap->getId() . ';';
			echo '$(document).ready(function() {';
				echo 'loadSeatableTickets();';
			echo '});';
		echo '</script>';
		echo '<div id="seatmapCanvas">';
			echo '<i>Vennligst vent, laster inn...</i>';
		echo '</div>';
	}
	
	public function renderTutorial() {
		$user = Session::getCurrentUser();
		
		echo '<p>Velg en billett du vil plassere fra listen. Velg deretter hvor du vil sitte ved å trykke på et grønt sete.<br>';
		echo 'Billetter du kan plassere:</p>';
		
		if ($user->hasTicket()) {
			echo '<div id="seatableTickets"><i>Laster inn...</i></div>';
		} else {
			echo '<p>Du har ingen billetter! Du må kjøpe en billett før du kan plassere deg</p>';
		}
	}
}
?>