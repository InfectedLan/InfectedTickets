<?php
require_once 'handlers/eventhandler.php';
class TicketPage {
	public function render() {
		$currentEvent = EventHandler::getCurrentEvent();
		echo '<script src="scripts/seatmap.js"></script>';
		echo '<script src="../api/scripts/seatmapRenderer.js"></script>';
		echo '<script>';
			echo 'var seatmapId = ' . $currentEvent->getSeatmap() . ';';
			echo '$(document).ready(function() {';
				echo 'loadSeatableTickets();';
			echo '});';
		echo '</script>';
		echo '<div id="seatmapCanvas">';
			echo '<i>Vennligst vent, laster inn...</i>';
		echo '</div>';
	}
	
	public function renderTutorial() {
		echo '<p>Velg en billett du vil plassere fra listen. Velg deretter hvor du vil sitte ved å trykke på et grønt sete.<br>';
		echo 'Billetter du kan plassere:</p>';
		echo '<div id="seatableTickets"><i>Laster inn...</i></div>';
	}
}
?>