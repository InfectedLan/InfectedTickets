<?php
require_once 'utils.php';

require_once 'site.php';
require_once 'splashpage.php';
require_once 'ticketpage.php';

$scriptStart = microtime(true);

if (Utils::isAuthenticated()) {
	$page = new TicketPage();
	$page->render();
} else {
	$page = new SplashPage();
	$page->render();
}

$timeToGenerate = microtime(true)-$scriptStart;

echo "<!-- Page generated in " . ($timeToGenerate/1000) . " milliseconds -->";
?>