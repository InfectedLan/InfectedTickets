$(document).ready(function() {
	$("#ticketAmount").change(function(e) {
		$("#totalPrice").text(ticketPrice * $("#ticketAmount").val() );
	});
	$('#buyTicketForm').submit(function(e) {
		e.preventDefault();
		$.getJSON('../json/registerStoreSession.php?ticketType=' + ticketType + '&amount=' + $("#ticketAmount").val() , function(data){
			if(data.result) {
				//info(data.message); // TODO: Display "data.message" to user.
				location.reload();
			}
			else {
				error(data.message); // TODO: Display "data.message" to user.
			}
		});
	});
});
