<?php
/**
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

class TicketPage {
	public function render() {
		//echo 'Dersom du vil kontakte infected, kan vi nås per e-post hos <a href="mail://kontakt@infected.no">kontakt@infected.no</a>';
	}
	public function renderTutorial()
	{
		echo '<br />';
		echo '<p>';
			echo '<b>Arrangementsansvarlig</b><br />';
			echo 'Fredrik Warbo<br />';
			echo '99 76 77 45<br />';
			echo 'fredrik@warbo.org<br />';
		echo '</p>';	
	}
}
?>