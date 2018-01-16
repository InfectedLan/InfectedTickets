/**
 * This file is part of InfectedTickets.
 *
 * Copyright (C) 2015 Infected <http://infected.no/>.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 */

function reserveSeat(seatId) {
	if (seatingTicketId != 0) {
		$.getJSON('../api/json/ticket/seatTicket.php?ticket=' + seatingTicketId + "&seat="+seatId, function(data){
			if (data.result) {
				handleCustomDownloadAndRender();
			} else {
				error(data.message);
			}
	  });
	} else {
		error("Du har ingen billetter å plassere!");
	}
}

function loadSeatableTickets() {
	$.getJSON('../api/json/ticket/getSeatableTickets.php?seatmap=' + seatmapId, function(data){
		if (data.result) {
			$("#seatableTickets").html("");

			for (var i = 0; i < data.tickets.length; i++) {
				if (i == 0) {
					seatingTicketId = data.tickets[i].id;
				}

				$("#seatableTickets").append('<div class="ticket" id="ticket' + data.tickets[i].id + '"><img src="' + (i == 0 ? 'images/select.png' : 'images/noselect.png') + '" class="ticketCheckbox"/>' + data.tickets[i].owner + ' <i class="smallText">(' + data.tickets[i].humanName + ')</i></div>');
				$("#ticket" + data.tickets[i].id).click({id: data.tickets[i].id}, function(e){
					setSeatingTicket(e.data.id);
				});
			}
		} else {
			$("#seatableTickets").html('<i>En feil oppstod under håndteringen av bilettene du kan plassere...</i>');
		}

		handleCustomDownloadAndRender();
  });
}

var seatingTicketId = 0;

function setSeatingTicket(id) {
	seatingTicketId = id;

	$(".selectedTicket").removeClass("selectedTicket");
	$("#ticket" + id).addClass("selectedTicket");
	handleCustomRender();
}

var addHandlersCallback = function() {
	//Add handlers
	for (var i = 0; i < seatmapData.rows.length; i++) {
		for (var s = 0; s < seatmapData.rows[i].seats.length; s++) {
			if (!seatmapData.rows[i].seats[s].occupied) {
				$("#seat" + seatmapData.rows[i].seats[s].id).click({seatId: seatmapData.rows[i].seats[s].id}, function(e) {
					reserveSeat(e.data.seatId);
				});
			}
		}
	}
	$("#seatmapCanvas").append('<div class="seatExplanation"><span class="explanationBox free"></span> Ledig <span class="explanationBox taken"></span> Opptatt <span class="explanationBox current"></span> Min billett <span class="explanationBox friend"></span> Venn <span class="explanationBox reserved"></span> Reservert</div>');

};

function handleCustomRender() {
	renderSeatmap("#seatmapCanvas", function(identifyer, seatDivId, taken, takenData) {
		if (!taken) {
			return "free";
		}
		if (takenData.id == seatingTicketId) {
			return "current";
		}

		if(takenData.isFriend) {
			return "friend";
		}

		return "taken";
	}, addHandlersCallback);
	
}

function handleCustomDownloadAndRender() {
	downloadAndRenderSeatmap("#seatmapCanvas", function(identifyer, seatDivId, taken, takenData) {
		if (!taken) {
			return "free";
		}

		if (takenData.id == seatingTicketId) {
			return "current";
		}
		
		if(takenData.isFriend) {
			return "friend";
		}


		return "taken";
	}, addHandlersCallback);

}
