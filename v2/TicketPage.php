<?php
require_once '/../../api/utils.php';
require_once 'Site.php';
require_once '/../../api/handlers/UserHandler.php';

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
	            	echo '<img id="logo" src="images/logo.png"/>';
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
	                echo '<a href="#"><h1 style="border-left:0px; text-decoration:underline;">Kjøp billetter</h1></a>';
	                echo '<a href="#"><h1>Mine billetter</h1></a>';
	                echo '<a href="#"><h1>Reserver plass</h1></a>';
	                echo '<a href="#"><h1 style="border-right:0px">Kontakt</h1></a>';
	            echo '</div>';
	            echo '<div id="content">';
	            	echo '<h1>put things here in the #content div</h1>';
	            echo '</div>';
	            echo '<div class="banner">';
	            echo '</div>';
	    	echo '</div>';
	    	echo '<div id="errorbox" class="error">';
				echo '<span id="errorMsg">Placeholder error message here...</span>';
				echo '<div class="errorClose">X</div>';
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