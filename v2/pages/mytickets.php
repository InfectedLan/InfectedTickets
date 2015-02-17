<?php
require_once 'session.php';
require_once 'handlers/eventhandler.php';
require_once 'handlers/tickethandler.php';
require_once 'handlers/tickettransferhandler.php';

class TicketPage {
	public function render() {
		$ticketList = TicketHandler::getTicketsByUser(Session::getCurrentUser());
		echo '<h3>Årets arrangement</h3>';
		echo '<hr>';
		
		foreach ($ticketList as $ticket) {
			if ($ticket->getEvent()->equals(EventHandler::getCurrentEvent())) {
				self::printTicket($ticket);
				echo '<hr>';
			}
		}

		$revertableTickets = TicketTransferHandler::getRevertableTransfers(Session::getCurrentUser());

		foreach ($revertableTickets as $revertableTicket) {
			self::printRevertableTicket($revertableTicket);
			echo '<hr>';
		}
		
		echo '<h3>Tidligere arrangementer</h3>';
		echo '<hr>';
		
		foreach($ticketList as $ticket) {
			if (!$ticket->getEvent()->equals(EventHandler::getCurrentEvent())) {
				self::printOldTicket($ticket);
				echo '<hr>';
			}
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
					echo '<b>' . $ticket->getHumanName() . '</b>';
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
					echo '<b>' . $ticket->getHumanName() . '</b>';
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
					echo '<b>' . $ticket->getHumanName() . '</b>';
				echo '</td>';
				echo '<td width="18%">';
					echo '<input type="button" value="Overfør billetten" onclick="searchUser(\'Overfør billetten!\', function(user) { $.getJSON(\'../api/json/ticket/transferTicket.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" />';
				echo '</td>';
				echo '<td align="center" width="23%">';
					echo '<input type="button" value="Endre plassreserverer" onclick="searchUser(\'Sett som seater!\', function(user) { $.getJSON(\'../api/json/ticket/setTicketSeater.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" /><br />';
				echo '</td>';
				$seat = $ticket->getSeat();
				if(isset($seat))
				{
					echo '<td width="18%">';
						echo '<input type="button" value="Skriv ut billett" onclick="window.location.href = \'printTicket.php?id=' . $ticket->getId() . '&print\'"/>';
					echo '</td>';
					echo '<td width="18%">';
						echo '<input type="button" value="Mobil billett" onclick="window.location.href = \'printTicket.php?id=' . $ticket->getId() . '\'"/>';
					echo '</td>';
				}
				else
				{
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
						if(!isset($seater)) {
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