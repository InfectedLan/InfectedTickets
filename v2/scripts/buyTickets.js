$(document).ready(function() {
	$("#ticketAmount").change(function(e) {
		$("#totalPrice").text(ticketPrice * $("#ticketAmount").val() );
	});
	$('#buyTicketForm').submit(function(e) {
		e.preventDefault();
		$.getJSON('../json/getPaypalUrl.php?ticketType=' + ticketType + '&amount=' + $("#ticketAmount").val() , function(data){
			if(data.result) {
				window.location = data.url;
			}
			else {
				error(data.message);
			}
		});
	});
});
