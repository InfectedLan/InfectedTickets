<?php
require_once 'handlers/storesessionhandler.php';
require_once 'handlers/tickettypehandler.php';
require_once 'handlers/eventhandler.php';
require_once 'session.php';

class Page {
	public function render() {
		$user = Session::getCurrentUser();
		if( StoreSessionHandler::hasStoreSession( $user->getId() ) )
		{

		}
		else
		{
			$this->renderFirstStep();
		}
	}
	
	public function renderTutorial() {
		echo 'Step stuff goes here';
	}
	public function renderFirstStep() {
		$currentEvent = EventHandler::getCurrentEvent();
		$type = $currentEvent->getTicketType();
		echo '<h2>';
			echo 'Kjøper billett for Infected ';
			echo $currentEvent->getTheme();
			echo ' ( ';
			echo date("d", $currentEvent->getStartTime()) . 
	                    '. - ' . 
	                    date("d", $currentEvent->getEndTime()) . 
	                    '. ' . 
	                    date("F", $currentEvent->getStartTime()) . 
	                    '.';
	        echo ' )';
		echo '</h2>';
	}
}
?>