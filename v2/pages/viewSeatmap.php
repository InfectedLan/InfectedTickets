<?php
/**
 * This file is part of InfectedTickets.
 *
 * Copyright (C) 2015 Infected <http://infected.no/>.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'session.php';
require_once 'handlers/eventhandler.php';

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