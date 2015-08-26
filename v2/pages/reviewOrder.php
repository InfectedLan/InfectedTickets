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
require_once 'handlers/storesessionhandler.php';
require_once 'paypal/paypal.php';

class TicketPage {
	public function render() {
		//echo $_REQUEST['token'];
		$resArray = PayPal::getExpressCheckoutDetails($_REQUEST['token']);
		$user = Session::getCurrentUser();
		$storeSession = StoreSessionHandler::getStoreSessionByUser($user);
        if(isset($storeSession)) {
            $ticketType = $storeSession->getTicketType();
            //print_r($resArray);

            if (StoreSessionHandler::isPaymentValid($resArray['AMT'], $storeSession)) {
                echo '<h4>Vennligst se igjennom detaljene før du godkjenner betalingen.</h4>';
                echo '<table>';
				echo '<tr>';
                echo '<td class=eventnametop width="150px">Ditt navn</td>';
                echo '<td class=eventname width="300px">' . $resArray['FIRSTNAME'] . ' ' . $resArray['LASTNAME']. '</td>';
				echo '</tr>';
				echo '<tr>';
                echo '<td class=eventnametop>E-post</td>';
                echo '<td class=eventname>' . $resArray['EMAIL'] . '</td>';
				echo '</tr>';
				echo '<tr>';
                echo '<td class=eventnametop>Din id</td>';
                echo '<td class=eventname>' . $resArray['PAYERID'] . '</td>';
				echo '</tr>';
				echo '<tr>';
                echo '<td class=eventnametop>Totalsum</td>';
                echo '<td class=eventname>' . $resArray['AMT'] . '</td>';
				echo '</tr>';

				/*
                  echo '<tr>';
                  echo '<td class=eventnametop>Navn på billett</td>';
                  echo '<td class=eventname>" .$resArray["L_PAYMENTREQUEST_0_DESC0"]."</td>';
                  echo '</tr>';
				*/

				echo '<tr>';
                echo '<td class=eventnametop>Billett-type</td>';
                echo '<td class=eventname>' . $ticketType->getTitle() . '</td>';
				echo '</tr>';

				/*
                  echo '<tr>';'
                  echo '<td class=eventnametop>Antall</td>';
                  echo '<td class=eventname>' . $resArray['L_PAYMENTREQUEST_0_QTY0'] . '</td>';
                  echo '</tr>';
				*/
				echo '<tr>';
                echo '<td class=eventnametop>Antall</td>';
                echo '<td class=eventname>' . $storeSession->getAmount() . '</td>';
				echo '</tr>';
                echo '</table>';
                echo '<br />';
                echo '<form id="payForm" action="index.php?page=pay" method="POST">';
				echo '<input type="hidden" name="token" value="' . $_REQUEST['token'] . '">';
				//echo '<input type="hidden" name="paymentAmount" value="' . $resArray["AMT"] . '" />';
				//echo '<input type="hidden" name="paymentType" value="' . $_SESSION['paymentType'] . '" />';
				echo '<input type="hidden" name="payerID" value="' . $_REQUEST['PayerID'] . '">';
				echo '<input type="submit" value="Kjøp">';
                echo '</form>';
            } else {
                echo '<h1>Noe gikk galt!</h1>';
                echo '<p>Vi fikk vite fra paypal at du betalte ' . $resArray['AMT'] . ',-. Stemmer det?</p>';
            }
        } else {
            echo '<h1>Noe gikk galt</h1>';
            echo '<p>Billetten vi hadde reservert for deg er borte. Dette kan være grunnet at du brukte for lang tid hos paypal, eller på grunn av en teknisk feil. Å kjøpe billetten på nytt vil i de fleste tilfeller fikse dette. Om det ikke gjør det, kan du kontakte oss <a href="index.php&page=contact">her</a>, så skal vi prøve å fikse det for deg.</p>';
        }
		
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
