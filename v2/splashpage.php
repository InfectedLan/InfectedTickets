<?php
require_once 'handlers/tickethandler.php';
require_once 'handlers/tickettypehandler.php';

require_once 'site.php';

class SplashPage extends Site {
	private function renderHead() {
		echo "<head>";
			echo "<title>Logg inn - Infected</title>";
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
    		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/style_splash.css\">";
    		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style/shared.css\">";
    		
    		echo '<script src="scripts/jquery.js"></script>';
		echo "</head>";
	}
	
	private function outputScripts() {
		echo '<script src="scripts/splash.php"> </script>';
		echo '<script src="scripts/shared.php"> </script>';
	}
	
	private function renderBody() {
		echo '<body>';
			//Scripts
			$this->outputScripts();
	    	echo '<div class="outer">';
	        echo '<div class="middle">';
	        echo '<div class="inner">';
	        echo '<img id="logo" src="images/logo_trans2.png"/>';
	        	echo '<ul id="ul1">';
	        		//Login frame
	        		echo '<div id="loginFrame">';
			        	echo '<form id="loginForm">';
			            	echo '<li>';
			                    echo '<input class="input" name="username" type="input"/ placeholder="Brukernavn">';
			                echo '</li>';
			                echo '<li>';
			                    echo '<input class="input" name="password" type="password"/ placeholder="Passord">';
			                echo '</li>';
			                
			                echo '<li>';
			                    echo '<input class="button" id="submit" name="submit" type="submit"/ value="Logg inn">';
			                echo '</li>';
		                echo '</form>';
		                echo '<li>';
		                    echo '<input class="button" type="button"/ value="Registrer" onclick="showRegisterBox()">';
		                echo '</li>';
		                echo '<li>';
		                    echo '<input class="button" type="button"/ value="Glemt passord" onclick="showForgotBox()">';
		                echo '</li>';
		            echo '</div>';
		            //Register frame
		            echo '<div id="registerFrame" style="display:none;">';
		            	echo '<form id="registerForm">';
				        	echo '<li>';
				                    echo '<input class="input" name="firstname" type="input"/ placeholder="Fornavn">';
				            echo '</li>';
				            echo '<li>';
				                    echo '<input class="input" name="lastname" type="input"/ placeholder="Etternavn">';
				            echo '</li>';
				            echo '<li>';
				                    echo '<input class="input" name="username" type="input"/ placeholder="Brukernavn">';
				            echo '</li>';
				            echo '<li>';
				                    echo '<input class="input" name="password" type="password"/ placeholder="Passord">';
				            echo '</li>';
				            echo '<li>';
				                    echo '<input class="input" name="confirmpassword" type="password"/ placeholder="Gjenta passord">';
				            echo '</li>';
				            echo '<li>';
				                    echo '<input class="input" name="email" type="email"/ placeholder="E-post addresse">';
				            echo '</li>';
				            echo '<li>';
				            	echo '<i>Kjønn:</i>';
				            	echo '<select class="select" name="gender" placeholder="Kjønn">';
									echo '<option value="0">Mann</option>';
									echo '<option value="1">Kvinne</option>';
								echo '</select>';
				            echo '</li>';
				            echo '<li>';
				            	echo '<i>Fødselsdato:</i>';
				            echo '</li>';
				            echo '<li>';
				            	echo '<select name="birthday">';
				            		for ($day = 1; $day < 32; $day++) {
										echo '<option value="' . $day . '">' . $day . '</option>';
									}
				            	echo '</select>';
				            	echo '<select name="birthmonth">';
				            		$monthList = array('Januar',
										'Februar',
										'Mars',
										'April',
										'Mai',
										'Juni',
										'Juli',
										'August',
										'September', 
										'Oktober',
										'November',
										'Desember');
									
									for ($month = 1; $month < 13; $month++) {
										echo '<option value="' . $month . '">' . $monthList[$month - 1] . '</option>';
									}
				            	echo '</select>';
				            	echo '<select name="birthyear">';
				            		for ($year = date('Y') - 100; $year < date('Y'); $year++) {
										if ($year == date('Y') - 18) {
											echo '<option value="' . $year . '" selected>' . $year . '</option>';
										} else {
											echo '<option value="' . $year . '">' . $year . '</option>';
										}
									}
				            	echo '</select>';
				            echo '</li>';
				            echo '<li>';
				            	echo '<input class="input" name="phone" type="tel"/ placeholder="Telefonnummer">';
				            echo '</li>';
				            echo '<li>';
				            	echo '<input class="input" name="address" type="input"/ placeholder="Gateadresse">';
				            echo '</li>';
				            echo '<li>';
				            	echo '<input class="input" name="postalCode" type="number"/ placeholder="Postnummer">';
				            echo '</li>';
				            echo '<li>';
				            	echo '<input class="input" name="nickname" type="text"/ placeholder="Kallenavn/nick">';
				            echo '</li>';
				            echo '<li>';
				            	echo '<input class="input" name="parent" type="tel"/ placeholder="Foresattes telefon">';
				            	echo '<i>(Påkrevd hvis du er under 18)</i>';
				            echo '</li>';
				            echo '<li>';
				            	echo '<input class="button" id="submit" name="submit" type="submit"/ value="Registrer">';
				            echo '</li>';
			            echo '</form>';
			            //Go back button
			            echo '<li>';
			            echo '</li>';
			            echo '<li>';
			            	echo '<input class="button" type="button"/ value="Gå tilbake" onclick="showLoginBoxFromRegister()">';
			            echo '</li>';
		            echo '</div>';
		            echo '<div id="forgotFrame" style="display:none;">';
		            	echo '<li>';
		            		echo 'Dersom du har glemt passordet ditt, kan du skrive inn e-post addresseen din her og få en kode tilsendt for å endre passordet.';
			            echo '</li>';
			            echo '<li>';
			                echo '<input class="input" name="email" type="email"/ placeholder="E-post addresse">';
			            echo '</li>';
			            echo '<li>';
			                echo '<input class="button" id="submit" name="submit" type="submit"/ value="Send e-post">';
			            echo '</li>';
			            //Go back button
			            echo '<li>';
			            echo '</li>';
			            echo '<li>';
			            	echo '<input class="button" type="button"/ value="Gå tilbake" onclick="showLoginBoxFromForgot()">';
			            echo '</li>';
		            echo '</div>';
	            echo '</ul>';
	            echo '<ul id="ul2">';
	            	echo '<li>';
	            		//List next lan's date
	            		$event = EventHandler::getCurrentEvent();
	                	echo 'Neste Lan er:';
	                	echo '<br/>';
	                    echo date("d", $event->getStartTime()) . 
		                    '. - ' . 
		                    date("d", $event->getEndTime()) . 
		                    '. ' . 
		                    date("F", $event->getStartTime()) . 
		                    '.';
	                    echo '<br/>';
		                    echo 'Dørene åpner ' . 
		                    date("H:i", $event->getStartTime()) . 
		                    '.';
	               	echo '</li>';
	                
	                echo '<li>';
	                    echo 'Antall Billetter igjen: <b>' . TicketHandler::getAvailableTickets() . '</b>';
	                echo '</li>';
	                
	                echo '<li>';
	                	$ticketType = $event->getTicketType();
	                    echo 'Pris: ' . $ticketType->getPrice() . ',- inkludert medlemskap i Radar.';
	                echo '</li>';
	                echo '<li>';
	                    echo '<i>Du har samme bruker på tickets og crew-siden.</i>';
	                echo '</li>';
	            echo '</ul>';
	        echo '</div>';
	        echo '</div>';
	        echo '</div>';
	        echo '<div id="errorbox" class="error">';
				echo '<span id="errorMsg">Placeholder error message here...</span>';
				echo '<div class="errorClose">X</div>';
			echo '</div>';
	    echo '</body>';
	}
	
	public function render() {
		echo "<html>";
			$this->renderHead();
			$this->renderBody();
		echo "</html>";
	}
}
?>