<?php
require_once 'session.php';
require_once 'dateutils.php';
require_once 'handlers/emergencycontacthandler.php';

class TicketPage {
	public function render() {
			$user = Session::getCurrentUser();
	
			echo '<script src="../api/scripts/edit-profile.js"></script>';
			echo '<script src="../api/scripts/lookupCity.js"></script>';
			echo '<form class="edit-profile" method="post">';
				echo '<input type="hidden" name="id" value="' . $user->getId() . '">';
				echo '<table>';
					echo '<tr>';
						echo '<td>Fornavn:</td>';
						echo '<td><input type="text" name="firstname" value="' . $user->getFirstname() . '" required autofocus></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Etternavn:</td>';
						echo '<td><input type="text" name="lastname" value="' . $user->getLastname() . '" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Brukernavn:</td>';
						echo '<td><input type="text" name="username" value="' . $user->getUsername() . '" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>E-post:</td>';
						echo '<td><input type="email" name="email" value="' . $user->getEmail() . '" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Kjønn:</td>';
						echo '<td>';
							echo '<select name="gender">';
								$gender = $user->getGender();
								
								if ($gender == 0) {
									echo '<option value="0" selected>Mann</option>';
									echo '<option value="1">Kvinne</option>';
								} else if ($gender == 1) {
									echo '<option value="0">Mann</option>';
									echo '<option value="1" selected>Kvinne</option>';
								}
							echo '</select>';
						echo '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Fødselsdato:</td>';
						echo '<td>';
							$birthdate = $user->getBirthdate();
						
							echo '<select name="birthday">';
								for ($day = 1; $day < 32; $day++) {
									if ($day == date('d', $birthdate)) {
										echo '<option value="' . $day . '" selected>' . $day . '</option>';
									} else {
										echo '<option value="' . $day . '">' . $day . '</option>';
									}
								}
							echo '</select>';
							echo '<select name="birthmonth">';					
								for ($month = 1; $month < 13; $month++) {
									if ($month == date('m', $birthdate)) {
										echo '<option value="' . $month . '" selected>' . DateUtils::getMonthFromInt($month) . '</option>';
									} else {
										echo '<option value="' . $month . '">' . DateUtils::getMonthFromInt($month) . '</option>';
									}
								}
							echo '</select>';
							echo '<select name="birthyear">';
								for ($year = date('Y') - 100; $year < date('Y'); $year++) {
									if ($year == date('Y', $birthdate)) {
										echo '<option value="' . $year . '" selected>' . $year . '</option>';
									} else {
										echo '<option value="' . $year . '">' . $year . '</option>';
									}
								}
							echo '</select>';
						echo '</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Telefon:</td>';
						echo '<td><input type="tel" name="phone" value="' . $user->getPhone() . '" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Gateadresse:</td>';
						echo '<td><input type="text" name="address" value="' . $user->getAddress() . '" required></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Postnummer:</td>';
						echo '<td><input class="postalcode" type="number" name="postalcode" min="1" max="9999" value="' . $user->getPostalCode() . '" required></td>';
						echo '<td><span class="city">' . $user->getCity() . '</span></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Nickname:</td>';
						echo '<td><input type="text" name="nickname" value="' . $user->getNickname() . '"></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>Foresatte\'s telefon:</td>';
							if (EmergencyContactHandler::hasEmergencyContactByUser($user)) {
								$emergencyContactPhone = EmergencyContactHandler::getEmergencyContactByUser($user)->getPhone();
							
								echo '<td><input name="emergencycontactphone" type="tel" value="' . $emergencyContactPhone . '"></td>';
							} else {
								echo '<td><input name="emergencycontactphone" type="tel"></td>';
							}
						echo '<td><i>(Påkrevd hvis du er under 18)</i></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><input type="submit" value="Lagre"></td>';
						echo '<td><input type="button" value="Endre passord" onClick=\'window.location="index.php?page=edit-password"\'></td>';
					echo '</tr>';
				echo '</table>';
			echo '</form>';
	}
	
	public function renderTutorial() {
		echo '<h1>Min profil</h1>';
		echo '<p>';
			echo 'Her kan du se på og endre informasjon om brukeren din. Denne informasjonen er nødt til å være korrekt for at du skal slippe inn, så ta deg litt tid til å se igjennom her';
		echo '</p>';
	}
}
?>