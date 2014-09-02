<?php
require_once 'session.php';
require_once 'settings.php';
require_once 'utils.php';
require_once 'handlers/eventhandler.php';
require_once 'handlers/tickethandler.php';

class Site {
	// Variable definitions.
	private $pageName;
	
	public function __construct() {
		// Set the variables.
		$this->pageName = isset($_GET['page']) ? $_GET['page'] : 'buytickets';
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
				echo '<link rel="shortcut icon" href="images/favicon.ico">';
				echo '<link rel="stylesheet" href="style/shared.css">';
				
				if (Session::isAuthenticated()) {
					echo '<link rel="stylesheet" href="style/style.css">';
					echo '<style>';
						echo '#imgContainer {';
							echo 'background: #000000 url(\'' . $this->getBackground(true) . '\');';
							echo 'background-repeat: no-repeat;';
							echo 'background-size: 100% auto;';
						echo '}';
					echo '</style>';
				} else {
					echo '<link rel="stylesheet" href="style/style_splash.css">';
					echo '<style>';
						echo 'body {';
							echo 'background: #000000 url(\'' . $this->getBackground(false) . '\');';
							echo 'background-repeat: no-repeat;';
							echo 'background-size: 100% auto;';
							echo 'background-position: center;';
						echo '}';
					echo '</style>';
				}

				echo '<link rel="shortcut icon" href="images/favicon.ico">';
				echo '<script src="../api/scripts/jquery-1.11.1.min.js"></script>';
				echo '<script src="scripts/shared.js"></script>';
				echo '<script>';
					echo '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
					echo '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
					echo 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
					echo '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';

					echo 'ga(\'create\', \'UA-54254513-2\', \'auto\');';
					echo 'ga(\'send\', \'pageview\');';
				echo '</script>';	
			echo '</head>';
			echo '<body>';
				if (Session::isAuthenticated()) {
					$user = Session::getCurrentUser();
					echo '<script src="../api/scripts/logout.js"></script>';
					echo '<script src="scripts/ticketscripts.js"></script>';
					echo '<div id="imgContainer">';
						echo '<div class="bgControl" id="leftBgImg"></div>';
						echo '<div class="bgControl" id="rightBgImg"></div>';
					echo '</div>';
					echo '<div id="container">';
						echo '<div id="header">';
							echo '<a href="index.php"><img id="logo" src="images/logo.png"></a>';
							echo '<div id="colorChange">';
							/*
								echo '<div class="cc" id="cPink" title="Hot Pink"></div>';
								echo '<div class="cc" id="cBlue" title="Cool Blue"></div>';
								echo '<div class="cc" id="cGreen" title="Infected Green"></div>';
							*/
							echo '</div>';
							echo '<div id="whenLoggedIn">';
								echo '<span> Du er nå logget in som ' . $user->getFullName() . '</span>';
								echo '<div style="clear:both";></div>';
								echo '<input type="button" value="Logg ut" onClick="logout()">';
								echo '<input type="button" value="Min profil" onClick=\'window.location="index.php?page=my-profile"\'>';
							echo '</div>';
						echo '</div>';
						//Has to be done before the banner
						//echo '<h1>put things here in the #content div</h1>';
						$currentEvent = EventHandler::getCurrentEvent();
						$numTickets = TicketHandler::getTicketsForOwnerAndEvent($user, $currentEvent);

						$pageToInclude = 'pages/buytickets.php';
						$defaultPage = "buytickets";
						
						if (!empty($numTickets)) {
							$defaultPage = "mytickets";
							$pageToInclude = 'pages/mytickets.php';
						}
						
						//Banner
						echo '<div class="banner" id="nav">';
							$pageString = (isset($_GET['page']) ? $_GET['page'] : $defaultPage);
							$underlined = ' style="border-left:0px; text-decoration:underline;"';
							echo '<a href="index.php?page=buytickets"><h1' . ($pageString == 'buytickets' ? $underlined : '') . '>Kjøp billetter</h1></a>';
							echo '<a href="index.php?page=mytickets"><h1' . ($pageString == 'mytickets' ? $underlined : '') . '>Mine billetter</h1></a>';
							echo '<a href="index.php?page=viewSeatmap"><h1' . ($pageString == 'viewSeatmap' ? $underlined : '') . '>Plassreservering</h1></a>';
							echo '<a href="index.php?page=contact"><h1' . ($pageString == 'contact' ? $underlined : '') . '>Kontakt</h1></a>';
						echo '</div>';
						
						//Make sure it is not trying to access something outside the pages directory
						if (isset($_GET['page']) && !empty($_GET['page'])) {
							if (file_exists('pages/' . $this->pageName . '.php')) {
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
					echo '<div id="fade"></div>';
					echo '<div id="prompt">';
						echo '<h3>Velg bruker</h3>';
						echo 'Start å skrive i tekstboksen, så kommer brukere opp. Du kan søke etter navn, brukernavn, e-post, telefonnummer, og nickname.<br>';
						echo '<input id="userSearchInput" type="text" name="userText"><br>';
						echo '<div id="userSearchContent"></div><br><br>';
						echo '<div id="userSelectedData"></div>';
					echo '</div>';
				} else {
					echo '<script src="../api/scripts/login.js"></script>';
					echo '<script src="scripts/splash.js"></script>';
					echo '<div class="outer">';
						echo '<div class="middle">';
							echo '<div class="inner">';
								echo '<img id="logo" src="images/logo.png" alt="Infected">';
								
								$publicPages = array('activation', 
													 'reset-password');
							
								if (isset($_GET['page']) && in_array($this->pageName, $publicPages)) {
									echo '<ul id="ul1">';
										$this->viewPage($this->pageName);
										echo '<li>';
											echo '<input class="button" type="button" value="Gå tilbake" onclick="showSplash()">';
										echo '</li>';
									echo '</ul>';
								} else {
									echo '<ul id="ul1">';
										//Login frame
										echo '<div id="loginFrame">';
											echo '<form class="login" method="post">';
												echo '<li>';
													echo '<input class="input" type="text" name="username" placeholder="Brukernavn">';
												echo '</li>';
												echo '<li>';
													echo '<input class="input" name="password" type="password" placeholder="Passord">';
												echo '</li>';
												
												echo '<li>';
													echo '<input class="button" id="submit" name="submit" type="submit" value="Logg inn">';
												echo '</li>';
											echo '</form>';
											echo '<li>';
												echo '<input class="button" type="button" value="Registrer" onclick="showRegisterBox()">';
											echo '</li>';
											echo '<li>';
												echo '<input class="button" type="button" value="Glemt passord" onclick="showForgotBox()">';
											echo '</li>';
										echo '</div>';
										//Register frame
										echo '<div id="registerFrame" style="display:none;">';
											echo '<script src="../api/scripts/register.js"></script>';
											echo '<script src="../api/scripts/lookupCity.js"></script>';
											echo '<form class="register" method="post">';
												echo '<li>';
														echo '<input type="text" name="firstname" placeholder="Fornavn" required autofocus>';
												echo '</li>';
												echo '<li>';
														echo '<input type="text"name="lastname" placeholder="Etternavn" required>';
												echo '</li>';
												echo '<li>';
														echo '<input type="text"name="username" placeholder="Brukernavn" required>';
												echo '</li>';
												echo '<li>';
														echo '<input type="password" name="password" placeholder="Passord" required>';
												echo '</li>';
												echo '<li>';
														echo '<input type="password" name="confirmpassword" placeholder="Gjenta passord" required>';
												echo '</li>';
												echo '<li>';
														echo '<input type="email" name="email" placeholder="E-post" required>';
												echo '</li>';
												echo '<li>';
													echo '<select class="select" name="gender" placeholder="Kjønn">';
														echo '<option value="0">Mann</option>';
														echo '<option value="1">Kvinne</option>';
													echo '</select>';
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
													echo '<input type="tel" name="phone" placeholder="Telefon" required>';
												echo '</li>';
												echo '<li>';
													echo '<input type="text" name="address" placeholder="Gateadresse" required>';
												echo '</li>';
												echo '<li>';
													echo '<input class="postalcode" type="number" name="postalcode" min="1" max="9999" placeholder="Postnummer" required>';
												echo '</li>';
												echo '<li>';
													echo '<span class="city"></span>';
												echo '</li>';
												echo '<li>';
													echo '<input name="nickname" type="text" placeholder="Kallenavn">';
												echo '</li>';
												echo '<li>';
													echo '<input name="emergencycontactphone" type="tel" placeholder="Foresatte\'s telefon">';
													echo '<i>(Påkrevd hvis du er under 18)</i>';
												echo '</li>';
												echo '<li>';
													echo '<input class="button" id="submit" name="submit" type="submit" value="Registrer">';
												echo '</li>';
											echo '</form>';
											//Go back button
											echo '<li>';
											echo '</li>';
											echo '<li>';
												echo '<input class="button" type="button" value="Gå tilbake" onclick="showLoginBoxFromRegister()">';
											echo '</li>';
										echo '</div>';
										echo '<div id="forgotFrame" style="display:none;">';
											echo '<script src="../api/scripts/reset-password.js"></script>';
											echo '<li>';
												echo '<form class="request-reset-password" method="post">';
													echo '<p>Skriv inn ditt brukernavnet eller din e-postadresse for å nullstille passordet ditt:</p>';
													echo '<input type="text" name="username" placeholder="Brukernavn eller e-post" required autofocus>';
													echo '<input class="button" type="submit" value="Nullstill passord">';
												echo '</form>';
											echo '</li>';
											//Go back button
											echo '<li>';
												echo '<input class="button" type="button" value="Gå tilbake" onclick="showLoginBoxFromForgot()">';
											echo '</li>';
										echo '</div>';
									echo '</ul>';
									echo '<ul id="ul2">';
										echo '<li>';
											$event = EventHandler::getCurrentEvent();
											$ticketText = $event->getTicketCount() > 1 ? 'billeter' : 'billett';
											
											echo '<p><b>Neste Lan er:</b><br>';
											echo date('d', $event->getStartTime()) . '. - ' . date('d', $event->getEndTime()) . '. ' . Utils::getMonthFromInt(date('m', $event->getEndTime())) . ' i ' . $event->getLocation()->getTitle() . '<br>';
											echo 'Det er <b>' . $event->getAvailableTickets() . '</b> av <b>' . $event->getParticipants() . '</b> ' . $ticketText . ' igjen<br>';
											echo 'Dørene åpner kl.' . date('H:i', $event->getStartTime()). '<br>';
											echo 'Pris per billett: ' . $event->getTicketType()->getPrice() . ',- inkludert medlemskap i Radar.</p>';
										echo '</li>';
									echo '</ul>';
								}
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
	
	// Generates title.
	private function getTitle() {
		return Settings::name . ' Tickets';
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
	
	private function viewPage($pageName) {
		$directoryList = array('pages');
		$includedPages = array();
		$found = false;
		
		foreach ($directoryList as $directory) {
			$filePath = $directory . '/' . $pageName . '.php';
		
			if (!in_array($pageName, $includedPages) &&
				in_array($filePath, glob($directory . '/*.php'))) {
				// Make sure we don't include pages with same name twice, 
				// and set the found varialbe so that we don't have to display the not found message.
				array_push($includedPages, $pageName);
				$found = true;
			
				include_once $filePath;
			}
		}
			
		if (!$found) {
			echo '<article>';
				echo '<h1>Siden ble ikke funnet!</h1>';
			echo '</article>';
		}
	}
}
?>