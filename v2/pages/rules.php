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

require_once 'handlers/pagehandler.php';

class TicketPage {
	public function render() {
		if(!isset($_POST['ticketAmount'])){
			echo '<b>Du skal ikke være her. Trykk "Kjøp billetter" for å kjøpe billetter</b>';
			return;
		}
		echo '<h1>Før du kan kjøpe billetter, må du godta disse reglene.</h1>';
		echo '<p>Dette er for din egen, og andres sikkerhet.</p>';

		echo '<div id="ticketRules">';

			$page = PageHandler::getPage(2); //Rules?
			echo $page->getContent();

		echo '</div>';

		echo '<br />';
		echo '<p>Jeg har lest og godtatt reglene<input type="checkbox" id="acceptedRulesBox" /></p>';

		//POSTed data
		$ticketType = $_POST['ticketType'];
		$ticketAmount = $_POST['ticketAmount'];

		echo '<script src="scripts/buyTickets.js"></script>';
		echo '<br />';
		echo '<p><input type="button" value="Kjøp billett(er)" onclick="goToPaypal(' . $ticketType . ', ' . $ticketAmount . ')" /><div id="loadingIcon"></div></p>';
		echo '<p><i>Ved å trykke her vil du bli sendt til paypal for å godkjenne betalingen</i></p>';
		echo '<br /><br />';
	}
	
	public function renderTutorial() {
		echo '<h1 style="margin-bottom:0px;">Slik kjøper du billett</h1>';
		echo '<center>';
			echo '<table width="100%">';
				echo '<tr>';
					echo '<td style="text-align:center">';
						echo '<h3 style="margin: 0px">1. Velg antall</h3>';
						echo '<img src="images/tickets.jpg" />';
					echo '</td>';
					echo '<td style="text-align:center">';
						echo '<h3 style="margin: 0px">2. Godkjenn regler og rettningslinjer</h3>';
						echo '<img src="images/rules.jpg" />';
					echo '</td>';
					echo '<td style="text-align:center">';
						echo '<h3 style="margin: 0px">3. Bekreft / Betal</h3>';
						echo '<img src="images/confirm.jpg" />';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		echo '</center>';
		
		echo '<div id="divInstruks1">';
			echo '<p>Når du har kjøpt billett får du den/de under "Mine Billetter". Du velger plass etter at du har kjøpt billetten på "Plassreservering".</p>';
			
			
			echo '<p>Alle som skal på Infected må ha en bruker med en tilknyttet billett.';
	
			echo '<br><br>';
			echo '<p>Det er mulig å kjøpte billetter på vegne av andre brukere. Kjøp billetten(e) og overfor eierskap på "Mine billetter".</p>';
		echo'</div>';
	}
}
?>