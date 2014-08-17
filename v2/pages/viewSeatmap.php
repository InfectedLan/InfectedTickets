<?php
require_once 'handlers/eventhandler.php';
class Page {
	public function render() {
		$currentEvent = EventHandler::getCurrentEvent();
		echo '<script src="scripts/seatmap.js"></script>';
		echo '<script>';
			echo 'var seatmapId = ' . $currentEvent->getSeatmap() . ';';
			echo '$(document).ready(function() {';
				echo 'downloadAndRenderSeatmap();';
				echo 'loadSeatableTickets();';
			echo '});';
		echo '</script>';
		echo '<div id="seatmapCanvas">';
			echo '<i>Vennligst vent, laster inn...</i>';
		echo '</div>';
	}
	
	public function renderTutorial() {
		echo 'Klikk på et sete for å plassere deg';
	}
}
?>