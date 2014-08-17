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
	$("#seatmapCanvas").css('background-image', 'url("../api/content/' + seatmapData.backgroundImage + '")');
	for(var i = 0; i < seatmapData.rows.length; i++)
	{
		var returnData = [];

		returnData.push('<div class="row" style="top: ' + seatmapData.rows[i].y + 'px; left: ' + seatmapData.rows[i].x + 'px;" id="row' + seatmapData.rows[i].id + '">');
		for(var s = 0; s < seatmapData.rows[i].seats.length; s++)
		{
			var title = "Ledig sete";
			if(seatmapData.rows[i].seats[s].occupied)
			{
				title = 'Reservert av ' + seatmapData.rows[i].seats[s].occupiedBy;
			}

			returnData.push('<div title="' + title + '" class="seat ' + ( seatmapData.rows[i].seats[s].occupied ? 'taken' : 'free' ) + '" id="seat' + seatmapData.rows[i].seats[s].id + '">');
			returnData.push(seatmapData.rows[i].seats[s].humanName);
			returnData.push('</div>');
		}
		returnData.push('</div>');
		$("#seatmapCanvas").append(returnData.join(""));

		var rowId = seatmapData.rows[i].id;
		$("#row" + seatmapData.rows[i].id).click({row: rowId}, function(e) {
			selectRow(e.data.row);
		});
	}
}
function loadSeatableTickets() {
	$.getJSON('../api/json/getSeatableTickets.php?seatmap=' + seatmapId, function(data){
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