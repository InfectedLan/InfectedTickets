function reserveSeat(seatId) {
	$.getJSON('../api/json/ticket/seatTicket.php?ticket=' + seatingTicketId + "&seat="+seatId, function(data){
		if(data.result)
		{
			handleCustomDownloadAndRender();	
		}
		else
		{
			error(data.message);
		}
  	});
}
function loadSeatableTickets() {
	$.getJSON('../api/json/ticket/getSeatableTickets.php?seatmap=' + seatmapId, function(data){
		if(data.result)
		{
			$("#seatableTickets").html("");
			for(var i = 0; i < data.tickets.length; i++)
			{
				if(i==0)
				{
					seatingTicketId = data.tickets[i].id;
				}
				$("#seatableTickets").append('<div class="ticket' + (i == 0 ? ' selectedTicket' : '') + '" id="ticket' + data.tickets[i].id + '">' + data.tickets[i].owner + ' <i class="smallText">(' + data.tickets[i].humanName + ')</i></div>');
				$("#ticket" + data.tickets[i].id).click({id: data.tickets[i].id}, function(e){
					setSeatingTicket(e.data.id);
				});
			}
		}
		else
		{
			$("#seatableTickets").html('<i>En feil oppstod under håndteringen av bilettene du kan plassere...</i>');
		}
		handleCustomDownloadAndRender();
  	});
}
var seatingTicketId = 0;
function setSeatingTicket(id)
{
	seatingTicketId = id;

	$(".selectedTicket").removeClass("selectedTicket");
	$("#ticket" + id).addClass("selectedTicket");
	handleCustomRender();
}
var addHandlersCallback = function() {
	//Add handlers
	for(var i = 0; i < seatmapData.rows.length; i++)
	{
		for(var s = 0; s < seatmapData.rows[i].seats.length; s++)
		{
			if(!seatmapData.rows[i].seats[s].occupied)
			{
				$("#seat" + seatmapData.rows[i].seats[s].id).click({seatId: seatmapData.rows[i].seats[s].id}, function(e) {
					reserveSeat(e.data.seatId);
				});
			}
		}
	}
};
function handleCustomRender()
{
	renderSeatmap("#seatmapCanvas", function(identifyer, seatDivId, taken, takenData) {
		if(!taken) {
			return "free";
		}
		if(takenData.id == seatingTicketId) {
			return "current";
		}
		return "taken";
	}, addHandlersCallback);
}
function handleCustomDownloadAndRender()
{
	downloadAndRenderSeatmap("#seatmapCanvas", function(identifyer, seatDivId, taken, takenData) {
		if(!taken) {
			return "free";
		}
		if(takenData.id == seatingTicketId) {
			return "current";
		}
		return "taken";
	}, addHandlersCallback);
	
}