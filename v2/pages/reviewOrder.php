<?php
require_once 'session.php';
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/userhandler.php';
require_once 'paypal/paypal.php';
class TicketPage {
	public function render() {
		PayPal::handlePaypalRedirectData();
		$resArray=$_SESSION['reshash'];
		echo '<h4>Vennligst se igjennom detaljene før du godkjenner betalingen.</h4>';
		echo '<table>';
			echo "<tr><td class=eventnametop width=150px>Ditt navn</td><td class=eventname width=300px>" .$resArray["FIRSTNAME"]. $resArray["LASTNAME"]. "</td></tr>";  
			echo "<tr><td class=eventnametop>E-post</td><td class=eventname>" .$resArray["EMAIL"]."</td></tr>";  
			echo "<tr><td class=eventnametop>Din id</td><td class=eventname>" .$resArray["PAYERID"]."</td></tr>"; 
			echo "<tr><td class=eventnametop>Totalsum</td><td class=eventname>" .$resArray["AMT"]."</td></tr>";   
			echo "<tr><td class=eventnametop>Navn på billett</td><td class=eventname>" .$resArray["L_PAYMENTREQUEST_0_DESC0"]."</td></tr>";
			echo "<tr><td class=eventnametop>Antall</td><td class=eventname>" .$resArray["L_PAYMENTREQUEST_0_QTY0"]."</td></tr>";      
		echo '</table>';
		echo '<br />'
		echo '<form id="payForm" action="index.php?page=pay" method="POST">';
			echo '<input type="hidden" name="token" value="' . $_SESSION['token'] . '" />';
			echo '<input type="hidden" name="paymentAmount" value="' . $_SESSION['TotalAmount'] . '" />';
			echo '<input type="hidden" name="paymentType" value="' . $_SESSION['paymentType'] . '" />';
			echo '<input type="hidden" name="currentCodeType" value="' . $_SESSION['currCodeType'] . '" />';
			echo '<input type="hidden" name="payerID" value="' . $_SESSION['payer_id'] . '" />';
			echo '<input type="hidden" name="serverName" value="' . $_SESSION['SERVER_NAME'] . '" />';
			echo '<input type="submit" value="Kjøp" />';
		echo '</form>';
	}
	
	public function renderTutorial() {
		echo '<h1>Du er 1 steg unna å ha kjøpt billetter</h1>';
		echo '<b>Vennligst sørg for at alle detaljene nedenfor stemmer før du godkjenner betalingen</b>';
	}
}
?>