<?php
require_once 'utils.php';
require_once 'handlers/eventhandler.php';
require_once 'handlers/tickethandler.php';

class Page
{
	public function render()
	{
		/*echo '<h1>Mine biletter</h1>';
		echo '<p>Her kan du endre hvem som kommer til å bruke biletter du har kjøpt for kommende arrangement, samt se biletter du har kjøpt til tidligere arrangement</p>';*/
		$ticketArr = TicketHandler::getTicketsForOwner(Utils::getUser());
		echo '<h3>Årets arrangement</h3>';
		echo '<hr />';
		foreach($ticketArr as $tikkit)
		{
			if($tikkit->getEvent()->getId()==EventHandler::getCurrentEvent()->getId())
			{
				self::printTicket($tikkit);
			}
		}
	}
	public function renderTutorial()
	{
		echo 'Yolo';
	}
	
	private function printTicket($ticket)
	{
		//The code
		$seater = $ticket->getSeater();
		echo '<table>';
			echo '<tr>';
				echo '<td>';
					echo '<b>' . $ticket->getHumanName() . '</b>';
				echo '</td>';
				echo '<td>';
					echo '<input type="button" value="Overfør biletten" onclick="searchUser(\'Overfør billetten!\', function(user) { $.getJSON(\'http://' . $_SERVER['HTTP_HOST'] . '/api/json/transferTicket.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" />';
				echo '</td>';
				echo '<td>';
					echo '<input type="button" value="Endre plassreserverer" onclick="searchUser(\'Sett som seater!\', function(user) { $.getJSON(\'http://' . $_SERVER['HTTP_HOST'] . '/api/json/setSeater.php?id=' . $ticket->getId() . '&target=\' + user, handleJson); })" /><br />';
				echo '</td>';
				echo '<td>';
					echo '<input type="button" value="Skriv ut Billett" onclick="document.location(\'printTicket.php?id=' . $ticket->getId() . '\')"/>';
				echo '</td>';
				echo '<td>';
					echo '<input type="button" value="Lagre mobil versjon" />';
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
		echo '<hr />';
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