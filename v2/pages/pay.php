<?php
require_once 'session.php';
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/userhandler.php';
require_once 'paypal/paypal.php';
class Page {
	public function render() {
		$token =urlencode( $_POST['token']);
		$paymentAmount =urlencode ($_POST['paymentAmount']);
		$paymentType = urlencode($_POST['paymentType']);
		$currCodeType = urlencode($_POST['currCodeType']);
		$payerID = urlencode($_POST['payerID']);
		$serverName = urlencode($_POST['serverName']);	
		if(!isset($token))
		{
			echo "Du må komme fra en betaling!";
		}
		else
		{
			$result = PayPal::completePurchase($token, $paymentAmount, $paymentType, $currCodeType, $payerID, $serverName);	
		
			if($result==null)
			{
				echo "Det skjedde en feil under verifiseringen av betaingen!";
			}
			else
			{
				echo "Takk!";
				echo "<br />";
				echo 'Bestillingsreferansen din er <b>' . $result . '</b>';

				$numTickets = $_SESSION['qty'];
				for($i = 0; $i < $numTickets; $i++)
				{
					
				}
			}
		}
	}
	
	public function renderTutorial() {
	}
}
?>