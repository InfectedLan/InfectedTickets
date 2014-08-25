<?php
require_once 'session.php';
require_once 'handlers/eventhandler.php';
require_once 'handlers/tickethandler.php';

class TicketPage
{
	public function render()
	{
		/*echo '<h1>Mine biletter</h1>';
		echo '<p>Her kan du endre hvem som kommer til å bruke biletter du har kjøpt for kommende arrangement, samt se biletter du har kjøpt til tidligere arrangement</p>';*/
		$ticketArr = TicketHandler::getTicketsForOwner(Session::getCurrentUser());
		echo '<h3>Årets arrangement</h3>';
		echo '<hr />';
		foreach($ticketArr as $tikkit)
		{
			if($tikkit->getEvent()->getId()==EventHandler::getCurrentEvent()->getId())
			{
				self::printTicket($tikkit);
				echo '<hr />';
			}
		}
		echo '<h3>Tidligere arrangementer</h3>';
		echo '<hr />';
		foreach($ticketArr as $tikkit)
		{
			if($tikkit->getEvent()->getId() != EventHandler::getCurrentEvent()->getId())
			{
				self::printOldTicket($tikkit);
				echo '<hr />';
			}
		}
	}
	public function renderTutorial()
	{
		echo '<h1>Mine billetter</h1>';

		echo '<p>Har du kjøpt billett for en annen må den overføres til hans/huns bruker. Dette gjør du ved å trykke  ”Overfør billetten”</p>';

		echo '<p>Ønsker du at en annen skal velge plass for deg? Trykk på ”Endre plassreserverer” <br /> Dette gjør det enklere og komme samme i gruppe.</p>';

		echo '<p>Alle må ha med billett når de kommer på Infected, Du kan selv velge om du ønsker og skrive den ut eller bare ha den på Mobilen din.</p>';
	}

	private function printOldTicket($ticket)
	{
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
					if(!isset($seater))
						{
							echo "Seatet av deg";
						}
						else
						{
							echo 'Seatet av ' . $seater->getDisplayName();
						}
				echo '</td>';
				echo '<td>';
					echo 'Var arrangert på ' . $oldEvent->getLocation();
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
	
	private function printTicket($ticket)
	{
		//The code
		$seater = $ticket->getSeater();
		echo '<table>';
			echo '<tr>';
				echo '<td width="23%">';
					echo '<b>' . $ticket->getHumanName() . '</b>';
				echo '</td>';
				echo '<td width="18%">';
					echo '<input type="button" value="Overfør biletten" onclick="searchUser(\'Overfør billetten!\', function(user) { $.getJSON(\'../api/json/transferticket.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" />';
				echo '</td>';
				echo '<td align="center" width="23%">';
					echo '<input type="button" value="Endre plassreserverer" onclick="searchUser(\'Sett som seater!\', function(user) { $.getJSON(\'../api/json/setseater.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" /><br />';
				echo '</td>';
				echo '<td width="18%">';
					echo '<input type="button" value="Skriv ut Billett" onclick="window.location.href = \'printTicket.php?id=' . $ticket->getId() . '&print\'"/>';
				echo '</td>';
				echo '<td width="18%">';
					echo '<input type="button" value="Mobil bilett" onclick="window.location.href = \'printTicket.php?id=' . $ticket->getId() . '\'"/>';
				echo '</td>';
			echo '</tr>';
			//Seater row :P
			echo '<tr>';
				echo '<td></td>'; //name
				echo '<td></td>'; //transfer
				echo '<td>'; //seater
					echo '<center>';
						if(!isset($seater))
						{
							echo "(Deg)";
						}
						else
						{
							echo '(' . $seater->getDisplayName() . ')';
						}
					echo '</center>';
				echo '</td>';
				echo '<td></td>'; //print
				echo '<td></td>'; //mobile
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
}
?>