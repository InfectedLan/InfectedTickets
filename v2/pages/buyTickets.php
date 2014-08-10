<?php
require_once 'handlers/storesessionhandler.php';
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
		
	}
}
?>