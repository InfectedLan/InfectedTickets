<?php
require_once 'session.php';
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/userhandler.php';
require_once 'handlers/paymentloghandler.php';
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

		if(!isset($token))
		{
			echo "Du må komme fra en betaling!";
		}
		else
		{
			$user = Session::getCurrentUser();
			$storeSession = StoreSessionHandler::getStoreSessionForUser($user);

			if(!isset($storeSession))
			{
				echo 'Du har ingen reservert billett! Har du ventet for lenge med å betale? Kontakt support.';
			}
			else
			{
				$paymentAmount = $storeSession->getPrice();
			
				$result = PayPal::completePurchase($token, $paymentAmount, $currCodeType, $payerID, $serverName);	
			
				if($result==null)
				{
					echo "Det skjedde en feil under verifiseringen av betaingen!";
				}
				else
				{
					echo "<h1>Takk for din bestilling</h1>";
					echo "<br />";
					echo 'Bestillingsreferansen din er <b>' . $result . '</b>';
					PaymentLogHandler::createPayment($user, 
												  TicketTypeHandler::getTicketType( $storeSession->getTicketType() ), 
												  $storeSession->getAmount(), 
												  $storeSession->getPrice(), 
												  $result);
					NotificationManager::sendPurchaseCompleteNotification($user, $result);

					$success = StoreSessionHandler::purchaseComplete($storeSession);
					if(!$success)
					{
						echo '<br />';
						echo 'Det skjedde noe galt under registreringen av bilettene dine. Kontakt support.';
					}
					else
					{
						echo '<br />';
						echo 'Kjøpet ditt er registrert. Du kan nå plassere deg ved å trykke på "Plassreservering" oppe i menyen.';
					}
				}
			}
		}
	}
}
?>