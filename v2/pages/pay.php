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
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/userhandler.php';
require_once 'handlers/paymenthandler.php';
require_once 'paypal/paypal.php';
require_once 'notificationmanager.php';

class TicketPage {
	public function render() {
		
	}
	
	public function renderTutorial() {
		//Get stuff
		$token =urlencode( $_POST['token']);
		//$paymentAmount =urlencode ($_POST['paymentAmount']);
		$currCodeType = 'NOK';
		$payerID = urlencode($_POST['payerID']);
		$serverName = urlencode($_SERVER['SERVER_NAME']);

		if (!isset($token)) {
			echo "Du må komme fra en betaling!";
		} else {
			$user = Session::getCurrentUser();
			$storeSession = StoreSessionHandler::getStoreSessionByUser($user);

			if (!isset($storeSession)) {
				echo 'Du har ingen reservert billett! Har du ventet for lenge med å betale? Kontakt support.';
			} else {
				$paymentAmount = $storeSession->getPrice();
				$result = PayPal::completePurchase($token, $paymentAmount, $currCodeType, $payerID, $serverName);	
			
				if ($result == null) {
					echo "Det skjedde en feil under verifiseringen av betaingen!";
				} else {
					echo "<h1>Takk for din bestilling</h1>";
					echo "<br />";
					echo 'Bestillingsreferansen din er <b>' . $result . '</b>';
					$payment = PaymentHandler::createPayment($user, 
															 $storeSession->getTicketType(), 
															 $storeSession->getAmount(), 
															 $storeSession->getPrice(), 
															 $result);
					NotificationManager::sendPurchaseCompleteNotification($user, $result);

					$success = StoreSessionHandler::purchaseComplete($storeSession, $payment);
					
					if(!$success) {
						echo '<br />';
						echo 'Det skjedde noe galt under registreringen av bilettene dine. Kontakt support.';
					} else {
						echo '<br />';
						echo 'Kjøpet ditt er registrert. Du kan nå plassere deg ved å trykke på "Plassreservering" oppe i menyen.';
					}
				}
			}
		}
	}
}
?>