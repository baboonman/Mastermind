#!/usr/bin/php
<?php
	include 'classGame.php';
	include 'classOptions.php';

$opt = new Options();
list($gameRounds, $AILim, $autoMode, $nbGames) = $opt->getOpts();

$game = new Game($gameRounds, $AILim, $autoMode, $nbGames);
$game->playTheGame();
exit(0);
?>	
