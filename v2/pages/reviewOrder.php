<?php
require_once 'session.php';
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/userhandler.php';
require_once 'paypal/paypal.php';
class TicketPage {
	public function render() {
		//echo $_REQUEST['token'];
		$resArray = PayPal::getExpressCheckoutDetails($_REQUEST['token']);
		$user = Session::getCurrentUser();
		$storeSession = StoreSessionHandler::getStoreSessionForUser($user);
		//print_r($resArray);

		if(StoreSessionHandler::isPaymentValid($resArray['AMT'], $resArray["L_PAYMENTREQUEST_0_QTY0"], $storeSession))
		{
			echo '<h4>Vennligst se igjennom detaljene før du godkjenner betalingen.</h4>';
			echo '<table>';
				echo "<tr><td class=eventnametop width=150px>Ditt navn</td><td class=eventname width=300px>" .$resArray["FIRSTNAME"]. $resArray["LASTNAME"]. "</td></tr>";  
				echo "<tr><td class=eventnametop>E-post</td><td class=eventname>" .$resArray["EMAIL"]."</td></tr>";  
				echo "<tr><td class=eventnametop>Din id</td><td class=eventname>" .$resArray["PAYERID"]."</td></tr>"; 
				echo "<tr><td class=eventnametop>Totalsum</td><td class=eventname>" .$resArray["AMT"]."</td></tr>";   
				echo "<tr><td class=eventnametop>Navn på billett</td><td class=eventname>" .$resArray["L_PAYMENTREQUEST_0_DESC0"]."</td></tr>";
				echo "<tr><td class=eventnametop>Antall</td><td class=eventname>" .$resArray["L_PAYMENTREQUEST_0_QTY0"]."</td></tr>";      
			echo '</table>';
			echo '<br />';
			echo '<form id="payForm" action="index.php?page=pay" method="POST">';
				echo '<input type="hidden" name="token" value="' . $_REQUEST['token'] . '" />';
				echo '<input type="hidden" name="paymentAmount" value="' . $resArray["AMT"] . '" />';
				//echo '<input type="hidden" name="paymentType" value="' . $_SESSION['paymentType'] . '" />';
				echo '<input type="hidden" name="payerID" value="' . $_REQUEST['PayerID'] . '" />';
				echo '<input type="submit" value="Kjøp" />';
			echo '</form>';
		}
		else
		{
			echo '<h1>Noe gikk galt!</h1>';
			echo '<p>';
				echo 'Vi fikk vite fra paypal at du betalte ' . $resArray['AMT'] . ' for ' . $resArray["L_PAYMENTREQUEST_0_QTY0"] . ' billetter. Stemmer det?';
			echo '</p>';
		}
	}
	
	public function renderTutorial() {
		
	}
}
?>