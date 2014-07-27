<?php
require_once 'session.php';

require_once 'site.php';
require_once 'splashpage.php';
require_once 'ticketpage.php';

$scriptStart = microtime(true);

if (Session::isAuthenticated()) {
	$page = new TicketPage();
	$page->render();
} else {
	$page = new SplashPage();
	$page->render();
}

$timeToGenerate = microtime(true)-$scriptStart;

echo "<!-- Page generated in " . ($timeToGenerate/1000) . " milliseconds -->";
?>