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

require_once 'session.php';

if (!Session::isAuthenticated()) {
	echo '<script src="../api/scripts/reset-password.js"></script>';

	if (isset($_GET['code'])) {
		echo '<p>Skriv inn et nytt passord.</p>';

		echo '<form class="reset-password" method="post">';
			echo '<input type="hidden" name="code" value="' . $_GET['code'] . '">';

			echo '<li>';
				echo '<input type="password" name="password" placeholder="Nytt passord">';
			echo '</li>';
			echo '<li>';
				echo '<input type="password" name="confirmpassword" placeholder="Bekreft passord">';
			echo '</li>';
			echo '<li>';
				echo '<input class="button" type="submit" value="Endre">';
			echo '</li>';
		echo '</form>';
	} else {
		echo '<li>';
			echo '<p>Ingen tilbakestillings kode oppgitt, prøv igjen senere.</p>';
		echo '</li>';
	}
} else {
	echo '<li>';
		echo '<p>Siden du er logget inn, ser det ut til at du husker passordet ditt.</p>';
	echo '</li>';
}
?>
