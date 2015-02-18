<?php
require_once 'session.php';
require_once 'handlers/eventhandler.php';

class TicketPage {
	public function render() {
			$user = Session::getCurrentUser();
	
			echo '<h3>Endre passord</h3>';
	
			echo '<script src="../api/scripts/edit-password.js"></script>';
			echo '<form class="edit-password" method="post">';
				echo '<table>';
					echo '<tr>';
						echo '<td>Gammelt passord:</td>';
						echo '<td><input type="password" name="oldPassword" required autofocus></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Nytt passord:</td>';
						echo '<td><input type="password" name="newPassword" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Gjenta nytt passord:</td>';
						echo '<td><input type="password" name="confirmNewPassword" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><input type="submit" value="Lagre"></td>';
					echo '</tr>';
				echo '</table>';
			echo '</form>';
	}
	
	public function renderTutorial() {
		echo '<h1>Endre passord</h1>';
		echo '<p>';
			echo 'Dersom du av en eller annen grunn føler at du er nødt til å endre passordet ditt, kan du gjøre det her.';
		echo '</p>';
	}
}
?>