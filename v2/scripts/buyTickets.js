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

$(document).ready(function() {
	$("#ticketAmount").change(function(e) {
	    $("#totalPrice").text( ((ticketPrice - ticketDiscount) * $("#ticketAmount").val()) + (shouldPayMembershipFee ? ticketDiscount : 0) + ',-');
	});
});

function goToPaypal(ticketType, amount) {
	$("#loadingIcon").html('<img src="images/loading.gif" />');

	if ($("#acceptedRulesBox").prop('checked')) {
		$.getJSON('../api/json/pay/getPaypalUrl.php?ticketType=' + ticketType + '&amount=' + amount , function(data){
			if(data.result) {
				window.location = data.url;
			} else {
				error(data.message);
			}
		});
	} else {
		alert("Du må godta reglene for å kunne kjøpe billetter!");
	}
}
