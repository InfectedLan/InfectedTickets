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
require_once 'handlers/paymenthandler.php';
require_once 'paypal/paypal.php';
require_once 'notificationmanager.php';

class TicketPage {
	public function render() {

	}

	public function renderTutorial() {
		$token = urlencode( $_POST['token']);
		//$paymentAmount = urlencode ($_POST['paymentAmount']);
		$currCodeType = 'NOK';
		$payerID = urlencode($_POST['payerID']);
		$serverName = urlencode($_SERVER['SERVER_NAME']);

		if (!isset($token)) {
			echo 'Du må komme fra en betaling!';
		} else {
			$user = Session::getCurrentUser();
			$storeSession = StoreSessionHandler::getStoreSessionByUser($user);

			if (!isset($storeSession)) {
				echo 'Du har ingen reservert billett! Har du ventet for lenge med å betale? Kontakt support.';
			} else {
				$paymentAmount = $storeSession->getPrice();
				$result = PayPal::completePurchase($token, $paymentAmount, $currCodeType, $payerID, $serverName);

				if ($result == null) {
					echo 'Det skjedde en feil under verifiseringen av betalingen!';
				} else {
					echo '<h1>Takk for din bestilling</h1>';
					echo '<br />';
					echo 'Bestillingsreferansen din er <b>' . $result . '</b>';

					$payment = PaymentHandler::createPayment($user,
																									 $storeSession->getTicketType(),
															 										 $storeSession->getAmount(),
															 										 $storeSession->getPrice(),
															 										 $result);

					if (!StoreSessionHandler::purchaseComplete($storeSession, $payment)) {
						echo '<br />';
						echo 'Det skjedde noe galt under registreringen av bilettene dine. Kontakt support.';
					} else {
						echo '<br />';
						echo 'Kjøpet ditt er registrert. Du kan nå plassere deg ved å trykke på "Plassreservering" oppe i menyen.';

						NotificationManager::sendPurchaseCompleteNotification($user, $result);
					}
				}
			}
		}
	}
}
?>
