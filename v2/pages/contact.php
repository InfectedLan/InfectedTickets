<?php
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

class TicketPage {
	public function render() {
		//echo 'Dersom du vil kontakte infected, kan vi nås per e-post hos <a href="mail://kontakt@infected.no">kontakt@infected.no</a>';
	}

	public function renderTutorial() {
		echo '<br />';
		echo '<p>';
			echo '<b>Informasjons- og billettansvarlig</b><br />';
			echo 'Jens Andreas Schanche<br />';
			echo 'Telefon: 48 05 96 67<br />';
			echo 'ja.schanche@gmail.com<br />';
            echo 'Oppgaver: Informasjon og billettsalg.<br />';
		echo '</p>';
	}
}
?>
