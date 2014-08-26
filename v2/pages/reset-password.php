<?php
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