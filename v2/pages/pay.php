<?php
require_once 'session.php';
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/userhandler.php';
require_once 'paypal/paypal.php';
class TicketPage {
	public function render() {
		//Get stuff
		$token =urlencode( $_POST['token']);
		$paymentAmount =urlencode ($_POST['paymentAmount']);
		$currCodeType = 'NOK';
		$payerID = urlencode($_POST['payerID']);
		$serverName = urlencode($_SERVER['SERVER_NAME']);

		$user = Session::getCurrentUser();

		if(!isset($token))
		{
			echo "Du må komme fra en betaling!";
		}
		else
		{
			$storeSession = StoreSessionHandler::getStoreSessionForUser($user);
			$result = PayPal::completePurchase($token, $paymentAmount, $currCodeType, $payerID, $serverName);	
		
			if($result==null)
			{
				echo "Det skjedde en feil under verifiseringen av betaingen!";
			}
			else
			{
				echo "Takk!";
				echo "<br />";
				echo 'Bestillingsreferansen din er <b>' . $result . '</b>';

				$success = StoreSessionHandler::purchaseComplete($_SESSION['key'], $_SESSION['amt'], $_SESSION['qty'])
				if(!$success)
				{
					echo '<br />';
					echo 'Det skjedde noe galt under registreringen av bilettene dine. Kontakt support.';
				}
			}
		}
	}
	
	public function renderTutorial() {
	}
}
?>