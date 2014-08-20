<?php
require_once 'session.php';
require_once 'handlers/eventhandler.php';

class Site {
	// Variable definitions.
	private $pageName;
	
	public function __construct() {
		// Set the variables.
		$this->pageName = isset($_GET['viewPage']) ? $_GET['viewPage'] : null;
	}
	
	// Execute the site.
	public function execute() {
		echo '<!DOCTYPE html>';
		echo '<html>';
			echo '<head>';
				echo '<title>' . $this->getTitle() . '</title>';
				echo '<meta name="description" content="' . Settings::description . '">';
				echo '<meta name="keywords" content="' . Settings::keywords . '">';
				echo '<meta name="author" content="' . implode(', ', Settings::$authors) . '">';
				echo '<meta charset="UTF-8">';
				echo '<link rel="stylesheet" type="text/css" href="style/shared.css">';
				
				if (Session::isAuthenticated()) {
					echo '<link rel="stylesheet" type="text/css" href="style/style.css">';
					echo '<style>';
					echo '#imgContainer {';
						echo 'background: #000000 url(\'' . $this->getBackground(true) . '\');';
						echo 'background-repeat: no-repeat;';
						echo 'background-attachment: fixed;';
						echo 'background-size: 100% auto;';
						echo 'background-position: center;';
					echo '}';
				echo '</style>';
				} else {
					echo '<link rel="stylesheet" type="text/css" href="style/style_splash.css">';
					echo '<style>';
						echo 'body {';
							echo 'background: #000000 url(\'' . $this->getBackground(false) . '\');';
							echo 'background-repeat: no-repeat;';
							echo 'background-attachment: fixed;';
							echo 'background-size: 100% auto;';
							echo 'background-position: center;';
						echo '}';
					echo '</style>';
				}

				echo '<link rel="shortcut icon" href="images/favicon.ico">';
				echo '<script src="../api/scripts/jquery.js"></script>';
				echo '<script src="../api/scripts/jquery.form.min.js"></script>';
				echo '<script src="scripts/shared.php"></script>';
			echo '</head>';
			echo '<body>';
				if (Session::isAuthenticated()) {
					$user = Session::getCurrentUser();
					echo '<script src="../api/scripts/logout.js"></script>';
					echo '<script src="scripts/ticketscripts.php"></script>';
					echo '<div id="imgContainer">';
						echo '<div class="bgControl" id="leftBgImg"></div>';
						echo '<div class="bgControl" id="rightBgImg"></div>';
					echo '</div>';
					echo '<div id="container">';
						echo '<div id="header">';
							echo '<a href="index.php?page=default"><img id="logo" src="images/logo.png"/></a>';
							echo '<div id="colorChange">';
								echo '<div class="cc" id="cPink" title="Hot Pink"></div>';
								echo '<div class="cc" id="cBlue" title="Cool Blue"></div>';
								echo '<div class="cc" id="cGreen" title="Infected Green"></div>';
							echo '</div>';
							echo '<div id="whenLoggedIn">';
								echo '<span> Du er nå logget in som ' . $user->getFirstname() . ' ' . $user->getLastname() . '</span>';
								echo '<div style="clear:both";></div>';
								echo '<input type="button" value="Logg ut" onClick="logout()">';
								echo '<input type="button" value="Min profil">';
							echo '</div>';
						echo '</div>';
						echo '<div class="banner" id="nav">';
							echo '<a href="index.php?page=buyTickets"><h1 style="border-left:0px; text-decoration:underline;">Kjøp billetter</h1></a>';
							echo '<a href="index.php?page=tickets"><h1>Mine billetter</h1></a>';
							echo '<a href="index.php?page=viewSeatmap"><h1>Plassreservering</h1></a>';
							echo '<a href="index.php?page=contact"><h1 style="border-right:0px">Kontakt</h1></a>';
						echo '</div>';
						//echo '<h1>put things here in the #content div</h1>';
						$pageToInclude = 'pages/default.php';
						//Make sure it is not trying to access something outside the pages directory
						
						if (isset($_GET["page"]) && !empty($_GET["page"]) && ctype_alpha($_GET["page"] )) {
							if(file_exists("pages/" . $_GET["page"] . '.php')) {
								$pageToInclude = "pages/" . $_GET["page"] . '.php';
							} else {
								$pageToInclude = "pages/404.php";
							}
						}
						
						include $pageToInclude;
						$contentPage = new TicketPage();

						echo '<div id="tutorial">';
						
						if (method_exists($contentPage, "renderTutorial")) {
							$contentPage->renderTutorial();
						}
						
						echo '</div>';
						echo '<div class="banner">';
						echo '</div>';
						echo '<div id="content">';
							$contentPage->render();
						echo '</div>';
					echo '</div>';
					echo '<div id="errorbox" class="error">';
						echo '<span id="errorMsg">Placeholder error message here...</span>';
						echo '<div class="errorClose">X</div>';
					echo '</div>';
					echo '<div id="fade" ></div>';
					echo '<div id="prompt">';
						echo '<h3>Velg bruker</h3>';
						echo 'Start å skrive i tekstboksen, så kommer brukere opp<br />';
						echo '<input id="userSearchInput" type="text" name="userText" /><br />';
						echo '<div id="userSearchContent"></div><br /><br />';
						echo '<div id="userSelectedData"></div>';
					echo '</div>';
				} else {
					echo '<script src="../api/scripts/login.js"></script>';
					echo '<script src="scripts/splash.php"></script>';
					echo '<div class="outer">';
						echo '<div class="middle">';
							echo '<div class="inner">';
								echo '<img id="logo" src="images/logo_trans2.png"/>';
									echo '<ul id="ul1">';
									//Login frame
									echo '<div id="loginFrame">';
										echo '<form class="login" method="post">';
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
													for ($month = 1; $month < 13; $month++) {
														echo '<option value="' . $month . '">' . Utils::getMonthFromInt($month) . '</option>';
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
											echo 'Antall Billetter igjen: <b>' . $event->getAvailableTickets() . '</b>';
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
				}
			echo '</body>';
		echo '</html>';
	}
	
	// Generates title based on current page / article.
	private function getTitle() {
		$theme = EventHandler::getCurrentEvent()->getTheme();
		$title = $theme != null ? Settings::name . ' ' . $theme : Settings::name;
		
		return $title;
	}
	
	// Picks randomly a background from the background directory.
	private function getBackground($authenticated) {
		$directory = 'images/backgrounds/';
		$suffix = 'jpg';
		$list = null;
		
		if ($authenticated) {
			$list = glob($directory . '/main/*.' . $suffix);
		} else {
			$list = glob($directory . '/splash/*.' . $suffix);
		}
		
		return $list[rand(0, count($list) - 1)];
	}
}
?>