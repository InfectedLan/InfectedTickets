<?php

$scriptStart = microtime(true);

require_once '/../../api/utils.php';
require_once 'Site.php';
require_once 'SplashPage.php';
require_once 'TicketPage.php';

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