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
require_once 'handlers/eventhandler.php';
require_once 'handlers/tickethandler.php';
require_once 'handlers/tickettransferhandler.php';

class TicketPage {
	public function render() {
		if (Session::isAuthenticated()) {
			$user = Session::getCurrentUser();

			$pendingFriends = $user->getPendingFriendsTo();



			if (!empty($pendingFriends)) {
				echo '<h3>Venneforespørsler</h3>';
				echo '<hr>';

				foreach ($pendingFriends as $friend) {
					echo '<table>';
						echo '<tr>';
							echo '<td>';
								echo $friend->getDisplayName();
							echo '</td>';
							echo '<td width="15%">';
								echo '<input type="button" value="Godta" onclick="$.post(\'../api/rest/user/friend/accept.php\', {friendId: ' . $friend->getId() . '}, handleJson);" /><br />';
							echo '</td>';
							echo '<td width="15%">';
								echo '<input type="button" value="Avslå" onclick="$.post(\'../api/rest/user/friend/reject.php\', {friendId: ' . $friend->getId() . '}, handleJson);" /><br />';
							echo '</td>';
						echo '</tr>';
					echo '</table>';
					echo '<hr>';
				}
			}

			$myPendingFriends = $user->getPendingFriendsFrom();

			if (!empty($myPendingFriends)) {
				echo '<h3>Utgående venneforespørsler</h3>';
				echo '<hr>';

				foreach ($myPendingFriends as $friend) {
					echo '<table>';
						echo '<tr>';
							echo '<td>';
								echo $friend->getDisplayName();
							echo '</td>';
						echo '</tr>';
					echo '</table>';
					echo '<hr>';
				}
			}

			echo '<br /><input type="button" value="Legg til ny venn" onclick="searchUser(\'Søk etter person å legge til\', function(user) { $.post(\'../api/rest/user/friend/create.php\', {friendId: user}, handleJson); })" /><br />';

			echo '<h3>Venner</h3>';
			echo '<hr>';

			$friendList = $user->getFriends();

			foreach ($friendList as $friend) {
				echo '<table>';
					echo '<tr>';
						echo '<td>';
							echo $friend->getDisplayName();
						echo '</td>';
						echo '<td width="15%">';
							echo '<input type="button" value="Fjern vennskap" onclick="$.post(\'../api/rest/user/friend/delete.php\', {friendId: ' . $friend->getId() . '}, handleJson);" /><br />';
						echo '</td>';
					echo '</tr>';
				echo '</table>';
				echo '<hr>';
			}

		} else {
			echo '<p>Du er ikke logget inn.</p>';
		}
	}

	public function renderTutorial() {
		echo '<h1>Venner</h1>';
		echo '<p>Her kan du legge til folk du kjenner. Ved å gjøre dette, kan du enkelt se hvor de sitter i salen, samt at du finner dem lettere ved søk</p>';
	}
}
?>
