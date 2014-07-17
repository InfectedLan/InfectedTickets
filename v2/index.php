<?php
require_once '../../api/Utils.php';
require_once 'Site.php';
require_once 'SplashPage.php';
require_once 'TicketPage.php';

$scriptStart = microtime(true);

if(Utils::isAuthenticated())
{
	$page = new TicketPage();
	$page->render();
}
else
{
	$page = new SplashPage();
	$page->render();
}

$timeToGenerate = microtime(true)-$scriptStart;

echo "<!-- Page generated in " . ($timeToGenerate/1000) . " milliseconds -->";
?>