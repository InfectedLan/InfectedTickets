var seatmapData = null;
function downloadAndRenderSeatmap()
{
	$.getJSON('../api/json/seatmapAvailability.php?id=' + seatmapId, function(data){
		if(data.result)
		{
			seatmapData = data;
			renderSeatmap();
		}
		else
		{
			$("#seatmapCanvas").html('<i>En feil oppstod under håndteringen av seatmappet...</i>');
		}
  	});
}
function renderSeatmap() {
	//Render seatmap
	$("#seatmapCanvas").html('');
	$("#seatmapCanvas").css('background-image', 'url("../api/content/seatmapBackground/' + seatmapData.backgroundImage + '")');
	for(var i = 0; i < seatmapData.rows.length; i++)
	{
		var returnData = [];

		returnData.push('<div class="row" style="top: ' + seatmapData.rows[i].y + 'px; left: ' + seatmapData.rows[i].x + 'px;" id="row' + seatmapData.rows[i].id + '">');
		for(var s = 0; s < seatmapData.rows[i].seats.length; s++)
		{
			var title = "Ledig sete";
			if(seatmapData.rows[i].seats[s].occupied)
			{
				title = 'Reservert av ' + seatmapData.rows[i].seats[s].occupiedTicket.owner;
			}
			//Seat is different based on state
			if(seatmapData.rows[i].seats[s].occupied)
			{
				if(seatmapData.rows[i].seats[s].occupiedTicket.id==seatingTicketId)
				{
					returnData.push('<div title="' + title + '" class="seat current" id="seat' + seatmapData.rows[i].seats[s].id + '">');
				}
				else
				{
					returnData.push('<div title="' + title + '" class="seat taken" id="seat' + seatmapData.rows[i].seats[s].id + '">');
				}
			}
			else
			{
				returnData.push('<div title="' + title + '" class="seat free" id="seat' + seatmapData.rows[i].seats[s].id + '">');
			}
			//Push rest of stuff
			returnData.push(seatmapData.rows[i].seats[s].humanName);
			returnData.push('</div>');
		}
		returnData.push('</div>');
		$("#seatmapCanvas").append(returnData.join(""));
		//Due to the stupid approach we are using here, we have to iterate twice for event listeners

		for(var s = 0; s < seatmapData.rows[i].seats.length; s++)
		{
			if(!seatmapData.rows[i].seats[s].occupied)
			{
				$("#seat" + seatmapData.rows[i].seats[s].id).click({seatId: seatmapData.rows[i].seats[s].id}, function(e) {
					reserveSeat(e.data.seatId);
				});
			}
		}
		/*var rowId = seatmapData.rows[i].id;
		$("#row" + seatmapData.rows[i].id).click({row: rowId}, function(e) {
			setSeatingTicket(e.data.row);
		}); */
	}
}
function reserveSeat(seatId) {
	$.getJSON('../api/json/seatTicket.php?ticket=' + seatingTicketId + "&seat="+seatId, function(data){
		if(data.result)
		{

			downloadAndRenderSeatmap();	
		}
		else
		{
			error(data.message);
		}
  	});
}
function loadSeatableTickets() {
	$.getJSON('../api/json/getSeatableTickets.php?seatmap=' + seatmapId, function(data){
		if(data.result)
		{
			$("#seatableTickets").html("");
			for(var i = 0; i < data.tickets.length; i++)
			{
				if(i==0)
				{
					seatingTicketId = data.tickets[i].id;
				}
				$("#seatableTickets").append('<div class="ticket' + (i == 0 ? ' selectedTicket' : '') + '" id="ticket' + data.tickets[i].id + '">' + data.tickets[i].owner + '</div>');
				$("#ticket" + data.tickets[i].id).click({id: data.tickets[i].id}, function(e){
					setSeatingTicket(e.data.id);
				});
			}
		}
		else
		{
			$("#seatableTickets").html('<i>En feil oppstod under håndteringen av bilettene du kan plassere...</i>');
		}
		downloadAndRenderSeatmap();
  	});
}
var seatingTicketId = 0;
function setSeatingTicket(id)
{
	seatingTicketId = id;

	$(".selectedTicket").removeClass("selectedTicket");
	$("#ticket" + id).addClass("selectedTicket");
	renderSeatmap();
}