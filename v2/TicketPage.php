<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/Utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/handlers/UserHandler.php';
require_once 'Site.php';

class TicketPage extends Site {
	private function renderHead()
	{
		echo "<head>";
			echo '<title>Tickets - Infected</title>';
	    	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	    	echo '<link rel="stylesheet" type="text/css" href="style/style.css">';
	    	echo '<link rel="stylesheet" type="text/css" href="style/shared.css">';
	        
	        
	        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>';
		echo "</head>";
	}
	
	private function outputScripts()
	{
		echo '<script src="scripts/ticketScripts.php"> </script>';
		echo '<script src="scripts/shared.php"> </script>';
	}
	
	public function renderNavBar()
	{
		echo '<a href="#"><h1 style="border-left:0px; text-decoration:underline;">Kjøp billetter</h1></a>';
        echo '<a href="index.php?page=tickets"><h1>Mine billetter</h1></a>';
        echo '<a href="#"><h1>Plassreservering</h1></a>';
        echo '<a href="index.php?page=contact"><h1 style="border-right:0px">Kontakt</h1></a>';
	}
	
	private function renderBody()
	{
		echo '<body>';
			//Scripts
			$this->outputScripts();
			$user = Utils::getUser();
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
	                    echo '<input type="button"/ value="Logg Ut" onClick="logOut()">';
	                    echo '<input type="button"/ value="Min Profil">';
	                echo '</div>';
	            echo '</div>';
	            echo '<div class="banner" id="nav">';
	                $this->renderNavBar();
	            echo '</div>';
	            //echo '<h1>put things here in the #content div</h1>';
            	$pageToInclude = 'pages/default.php';
            	//Make sure it is not trying to access something outside the pages directory
            	if ( isset($_GET["page"]) && !empty($_GET["page"]) && ctype_alpha( $_GET["page"] ) )
				{
					if(file_exists("pages/" . $_GET["page"] . '.php'))
					{
						$pageToInclude = "pages/" . $_GET["page"] . '.php';
					}
					else
					{
						$pageToInclude = "pages/404.php";
					}
				}
				include $pageToInclude;
				$contentPage = new Page();

	            echo '<div id="tutorial">';
            	if(method_exists($contentPage, "renderTutorial"))
            	{
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
				echo '<div id="userSearchContent"></div>';
			echo '</div>';
	    echo '</body>';
	}
	
	public function render()
	{
		echo "<html>";
			$this->renderHead();
			$this->renderBody();
		echo "</html>";
	}
}
?>