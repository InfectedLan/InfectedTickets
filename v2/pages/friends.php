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
require_once 'handlers/tickethandler.php';
require_once 'handlers/tickettransferhandler.php';

class TicketPage {
	public function render() {
		if (Session::isAuthenticated()) {
			$user = Session::getCurrentUser();

			$ticketList = $user->getTickets();

			if (!empty($ticketList)) {
				echo '<h3>Årets arrangement</h3>';
				echo '<hr>';

				foreach ($ticketList as $ticket) {
					if ($ticket->getEvent()->equals(EventHandler::getCurrentEvent())) {
						self::printTicket($ticket);
						echo '<hr>';
					}
				}
			}

			$revertableTicketList = TicketTransferHandler::getRevertableTransfers(Session::getCurrentUser());

			if (!empty($revertableTicketList)) {
				foreach ($revertableTicketList as $ticket) {
					self::printRevertableTicket($ticket);
					echo '<hr>';
				}
			}

			echo '<h3>Tidligere arrangementer</h3>';
			echo '<hr>';

			$previousTicketList = $user->getTicketsByAllEvents();

			if (!empty($previousTicketList)) {
				foreach ($previousTicketList as $ticket) {
					if (!$ticket->getEvent()->equals(EventHandler::getCurrentEvent())) {
						self::printOldTicket($ticket);
						echo '<hr>';
					}
				}
			}
		} else {
			echo '<p>Du er ikke logget inn.</p>';
		}
	}

	public function renderTutorial() {
		echo '<h1>Venner</h1>';
		echo '<p>Her kan du legge til folk du kjenner. Ved å gjøre dette, kan du enkelt se hvor de sitter i salen, samt få dem opp først under overføringer</p>';
		echo '<p>Ønsker du at en annen skal velge plass for deg? Trykk på #Endre plassreserverer# <br> Dette gjør det enklere og komme sammen i en gruppe.</p>';
		echo '<p>Alle må ha med billett når de kommer på Infected, Du kan selv velge om du ønsker og skrive den ut eller bare ha den på mobilen din.</p>';
	}
}
?>
