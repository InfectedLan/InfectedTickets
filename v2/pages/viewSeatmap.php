<?php
/**
 * This file is part of InfectedTickets.
 *
 * Copyright (C) 2015 Infected <http://infected.no/>.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'session.php';
require_once 'handlers/eventhandler.php';

class TicketPage {
	public function render() {
		$currentEvent = EventHandler::getCurrentEvent();
		$user = Session::getCurrentUser();
		$seatmap = $currentEvent->getSeatmap();

		echo '<script src="scripts/seatmap.js"></script>';
		echo '<script src="../api/scripts/seatmapRenderer.js"></script>';
		echo '<script>function seatingBlockCountdown(seconds) { setTimeout(function(){ $("#seatingBlockedOverlay").fadeOut(400); }, seconds*1000); }</script>';
		echo '<script>';
			echo 'var seatmapId = ' . $seatmap->getId() . ';';
			echo '$(document).ready(function() {';
				echo 'loadSeatableTickets();';
			echo '});';
		echo '</script>';
		if($currentEvent->getPrioritySeatingTime() < time()  && !$user->isEligibleForPreSeating()) {
		    echo '<script>seatingBlockCountdown(' . ($currentEvent->getSeatingTime() - time()) . ');</script>';
		    echo '<div id="seatingBlockedOverlay">';
		    	echo '<div class="seatingBlockMessage">';
		    	echo '<h1>Seating er for øyeblikket kun åpent for grupper på ' . Settings::prioritySeatingReq . ' eller fler</h1>';
			echo '<p>Du trenger å være sete-ansvarlig for <b>' . Settings::prioritySeatingReq . '</b> eller flere billetter å seate for å få tilgang på seating nå.<br>Om gruppen din er så mange, kan dere seate nå ved å sette en person som plassreserverer på alle bilettene. Dette kan gjøres <a href="index.php?page=mytickets">her</a>.<br><br>Vanelig seating starter om <b>' . round((($currentEvent->getSeatingTime() - time())/60), 0, PHP_ROUND_HALF_UP) . '</b> minutter.</p>';
		    	echo '</div>';
		    echo '</div>';
		} else if($currentEvent->getSeatingTime() > time()) {
		    $prioritySeatingStartDate = date('Y-m-d', $currentEvent->getPrioritySeatingTime()) == date('Y-m-d') ? 'i dag' : date('d', $currentEvent->getPrioritySeatingTime()) . '. ' . DateUtils::getMonthFromInt(date('m', $currentEvent->getPrioritySeatingTime()));
		    $seatingStartDate = date('Y-m-d', $currentEvent->getSeatingTime()) == date('Y-m-d') ? 'i dag' : date('d', $currentEvent->getSeatingTime()) . '. ' . DateUtils::getMonthFromInt(date('m', $currentEvent->getSeatingTime()));
		    if($user->isEligibleForPreSeating()) {
			echo '<script>seatingBlockCountdown(' . ($currentEvent->getPrioritySeatingTime() - time()) . ');</script>';
		    } else {
			echo '<script>seatingBlockCountdown(' . ($currentEvent->getSeatingTime() - time()) . ');</script>';
		    }
		    echo '<div id="seatingBlockedOverlay">';
		    	echo '<div class="seatingBlockMessage">';
		    	echo '<h1>Seatingen har ikke åpnet</h1>';
			echo '<p>Seatingen åpner for grupper <b>' . $prioritySeatingStartDate . ' kl ' . date('H:i', $currentEvent->getPrioritySeatingTime()) . '</b><br> Dvs. Du må ha en gruppe med <b>' . Settings::prioritySeatingReq . '</b> eller fler. <br>For å få gruppe må dere sette en person som sete-ansvarlig ved å sette personen som plassreserverer på billetten.<br><br>Seating for resten åpner  <b>' . $seatingStartDate . ' kl ' . date('H:i', $currentEvent->getSeatingTime()) . '</b></p>';
		    	echo '</div>';
		    echo '</div>';
		}
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
