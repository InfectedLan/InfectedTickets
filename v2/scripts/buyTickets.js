$(document).ready(function() {
	$("#ticketAmount").change(function(e) {
		$("#totalPrice").text(ticketPrice * $("#ticketAmount").val() );
	});
});
function goToPaypal(ticketType, amount)
{
	$("#loadingIcon").html('<img src="images/loading.gif" />');
	if($("#acceptedRulesBox").prop('checked')) {
		$.getJSON('../api/json/pay/getPaypalUrl.php?ticketType=' + ticketType + '&amount=' + amount , function(data){
			if(data.result) {
				window.location = data.url;
			}
			else {
				error(data.message);
			}
		});
	}
	else
	{
		alert("Du må godta reglene for å kunne kjøpe billetter!");
	}
}
