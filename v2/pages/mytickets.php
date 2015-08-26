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
		echo '<h1>Mine billetter</h1>';
		echo '<p>Har du kjøpt billett for en annen må den overføres til hans/huns bruker. Dette gjør du ved å trykke "Overfør billetten"</p>';
		echo '<p>Ønsker du at en annen skal velge plass for deg? Trykk på #Endre plassreserverer# <br> Dette gjør det enklere og komme sammen i en gruppe.</p>';
		echo '<p>Alle må ha med billett når de kommer på Infected, Du kan selv velge om du ønsker og skrive den ut eller bare ha den på mobilen din.</p>';
	}

	private function printOldTicket($ticket) {
		//The code
		$seater = $ticket->getSeater();
		$oldEvent = $ticket->getEvent();

		echo '<table>';
			echo '<tr>';
				echo '<td>';
					echo '<b>' . $ticket->getString() . '</b>';
				echo '</td>';
				echo '<td>';
					echo 'Ble arrangert den ' . date("j. M o", $oldEvent->getStartTime());
				echo '</td>';
				echo '<td>';
					if (!isset($seater)) {
						echo "Seatet av deg";
					} else {
						echo 'Seatet av ' . $seater->getDisplayName();
					}
				echo '</td>';
				echo '<td>';
					echo 'Ble arrangert på ' . $oldEvent->getLocation()->getTitle();
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		/*
		echo '<div class="ticket_div">';
			echo '<b>' . $ticket->getHumanName() . '</b>';
			if(!isset($sete))
			{
				echo '<b>Ikke plassert</b>';
			}
			echo '<br />';
			echo 'Eier: <b>' . $ticket->getOwner()->getDisplayName() . '</b><br />';
			echo 'Seater: <b>' . $ticket->getSeater()->getDisplayName() . '</b><br />';
		echo '</div>';
		*/
	}

	private function printRevertableTicket($revertableTicket) {
		$ticket = $revertableTicket->getTicket();
		$recipient = $revertableTicket->getTo();

		echo '<table>';
			echo '<tr>';
				echo '<td width="23%">';
					echo '<b>' . $ticket->getString() . '</b>';
				echo '</td>';
				echo '<td>';
					echo '<center><b>Overført til ' . $recipient->getDisplayName() . '</b></center>';
				echo '</td>';
				echo '<td width="15%">';
					echo '<input type="button" value="Angre" onclick="revertTransfer(' . $revertableTicket->getTicket()->getId() . ')" /><br />';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	}

	private function printTicket($ticket) {
		//The code
		$seater = $ticket->getSeater();

		echo '<table>';
			echo '<tr>';
				echo '<td width="23%">';
					echo '<b>' . $ticket->getString() . '</b>';
				echo '</td>';
				echo '<td width="18%">';
					echo '<input type="button" value="Overfør billetten" onclick="searchUser(\'Overfør billetten!\', function(user) { $.getJSON(\'../api/json/ticket/transferTicket.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" />';
				echo '</td>';
				echo '<td align="center" width="23%">';
					echo '<input type="button" value="Endre plassreserverer" onclick="searchUser(\'Sett som seater!\', function(user) { $.getJSON(\'../api/json/ticket/setTicketSeater.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" /><br />';
				echo '</td>';

				$seat = $ticket->getSeat();

				if (isset($seat)) {
					echo '<td width="18%">';
						echo '<input type="button" value="Skriv ut billett" onclick="window.location.href = \'printTicket.php?id=' . $ticket->getId() . '&print\'"/>';
					echo '</td>';
					echo '<td width="18%">';
						echo '<input type="button" value="Mobil billett" onclick="window.location.href = \'printTicket.php?id=' . $ticket->getId() . '\'"/>';
					echo '</td>';
				} else {
					echo '<td width="36%" colspan="2">';
						echo '<i>Du må plassere billetten før du kan printe den ut</i>';
					echo '</td>';
				}

			echo '</tr>';
			echo '<tr>';
				echo '<td></td>'; //name
				echo '<td></td>'; //transfer
				echo '<td>'; //seater
					echo '<center>';
						if (!isset($seater)) {
							echo "(Deg)";
						} else {
							echo '(' . $seater->getDisplayName() . ')';
						}
					echo '</center>';
				echo '</td>';
				echo '<td></td>'; //print
				echo '<td></td>'; //mobile
			echo '</tr>';
		echo '</table>';
	}
}
?>
