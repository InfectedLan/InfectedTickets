/*
 * This file is part of InfectedTickets.
 *
 * Copyright (C) 2015 Infected <http://infected.no/>.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

//View faders
function showSplash() {
	$(location).attr('href', '.');
}

function showRegisterBox() {
	$("#loginFrame").fadeOut(200, function() {
		$("#registerFrame").fadeIn(200);
	});
	$(".inner").animate({height:'550px'}, 200);
}

function showLoginBoxFromRegister() {
	$("#registerFrame").fadeOut(200, function() {
		$("#loginFrame").fadeIn(200);
		$(".inner").animate({height:'176px'}, 200);
	});
}

function showLoginBoxFromForgot() {
	$("#forgotFrame").fadeOut(200, function() {
		$("#loginFrame").fadeIn(200);
		$(".inner").animate({height:'176px'}, 200);
	});
}

function showForgotBox() {
	$("#loginFrame").fadeOut(200, function() {
		$("#forgotFrame").fadeIn(200);
	});
	$(".inner").animate({height:'230px'}, 200);
}