<?php
	require_once 'utils.php';
	require_once 'handlers/tickethandler.php';

	echo '<html>';
		echo '<head>';
			echo '<title>Biletten din</title>';
			echo '<link rel="stylesheet" type="text/css" href="style/ticket.css">';
		echo '</head>';
		echo '<body onload="window.print()">';
			//Validation
			if(!isset($_GET["id"]))
			{
				echo 'Ugyldig bilett-id</body></html>';
				return;
			}
			$ticket = TicketHandler::getTicket($_GET["id"]);
			if(!isset($ticket))
			{
				echo 'Biletten eksisterer ikke</body></html>';
				return;
			}
			echo '<div id="total">';
				echo '<h2>Billett: ' . $ticket->getHumanName() . '</h2>';
				echo '<table>';
					echo '<tr><td width="100px"><b>Navn:</b></td><td>' . $ticket->getOwner()->getFullName() . '</td></tr>';
					echo '<tr><td>Født:</td><td>' . date("j. F o", $ticket->getOwner()->getBirthdate()) .'</td></tr>';
					echo '<tr><td>Adresse:</td><td>' . $ticket->getOwner()->getAddress() . '</td></tr>';
					echo '<tr><td>Mobil:</td><td>' . $ticket->getOwner()->getPhone() . '</td></tr>';
					echo '<tr><td>Brukernavn:</td><td>' . $ticket->getOwner()->getUsername() . '</td></tr>';
					if(!isset($ticket->getSeat()))
					{
						echo '<tr><td>Sete:</td><td><b>IKKE PLASSERT</b></td></tr>';
					}
					else
					{
						echo '<tr><td>Sete:</td><td>' . $ticket->getSeat()->getHumanString() . '</td></tr>';
					}
					echo '<tr><td colspan="2"><b>Innsjekking: <a href="https://github.com/InfectedLan/InfectedAPI/issues/27">Please poke this issue</a></b></td></tr>';
					echo '<div id="inputdata"><img src="' . $ticket->getQr() . '" width="200px"/></div>';
				echo '</table>';
			echo '</div>';
			echo '<div id="tekstprint">Denne billetten skal vises ved innsjekking på Radar. Husk å ta med gyldig legitimasjon. De under 14 må ha med
bekreftelse fra foreldre. Skjema på nettsiden.</div>';
			echo '<div id="logo">'
				echo '<img src="images/logo_infected.jpg" width="299px">';
			echo '</div>';
		echo '</body>';
	echo '</html>';
?>