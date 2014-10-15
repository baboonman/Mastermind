<?php

include 'classTimer.php';
include 'classAttak.php';
include 'classDefense.php';

class			Game 	extends		Timer
{
	private $game = array();
	private $pAtt;
	private $pDef;
	private $round;
	private $in;
	private $mode;
	private $AILim;
	private $auto;
	private $nbGames;

	public function __construct($round, $AILim, $auto = false, $nbGames) {
		parent::__construct();
		if ($auto == false) {
			$this->getMode();
		}
		else {
			$this->mode = array(1,1);
			$this->in = 2;
		}
		$this->auto = $auto;
		$this->round = $round;
		$this->AILim = $AILim;
		$this->nbGames = $nbGames;
	}

	private function getMode() {
?>
MASTERMIND !!
attaque  ----  defense
0 -   J1      vs     IA
1 -   IA      vs     J1
2 -   IA      vs     IA
3 -   J1      vs     J2
What mode do you wanna play ? (0, 1, 2, 3)
<?php
		$allMode = array(array(0,1),array(1,0),array(1,1),array(0,0));
		$in = intval(trim(fgets(STDIN)));
		while ($in < 0 || $in > 3) {
			echo "Enter valid mode!! ";
			$in = intval(trim(fgets(STDIN)));
		}
		$this->mode = $allMode[$in];
		$this->in = $in;
	}

	private function showGame () {
		for($i = 0;$i < count($this->game);$i++)
			echo $this->game[$i] . "\n";
	}

	private function saveState ($try, $res) {
		$this->game[] = $try[0] . $try[1] . $try[2] . $try[3] 
						. "  \033[32m" . $res[0] . "\033[37m \033[31m" 
						. $res[1]  . "\033[37m";
	}

	public function playTheGame() 
	{
		if ($this->auto == true) {
			return $this->autoStatGame();
		}	
		else {
			$this->pAtt = new Attak($this->mode[0]);
			$this->pDef = new Defense($this->mode[1]);
			parent::refreshTime();
			return $this->playHuGame();
		}
	}

	private function playHuGame() {
		echo "\nGAME START!\n";
		for ($i = 1 ; $i <= $this->round ; $i++)
		{
			$this->showGame();
			$try = $this->pAtt->getTry();
			$res = $this->pDef->checkTry($try);
			$this->saveState($try, $res);
			$this->pAtt->computeRes($try, $res);
			if ($res[0] == 4) {
				$time_elapsed = parent::timeElapsed();
				echo "\nGAME END Attack won in {$i} rounds and {$time_elapsed}s!\n";
				return (array($i, $time_elapsed));
			}
		}
		echo "\nGAME END Defense won with: " . $this->pDef->getPassCode()."\n";
		return (array($this->round, parent::timeElapsed()));
	}

	private function playAIGame() {
		$this->pAtt = new Attak($this->mode[0], false);
		$this->pDef = new Defense($this->mode[1], false);
		echo "AI start cracking the code\n";
		parent::refreshTime();
		for ($i = 1; $i <= $this->AILim; $i++) {
			$try = $this->pAtt->getTry();
			$res = $this->pDef->checkTry($try, false);
			$this->pAtt->computeRes($try, $res);
			if ($res[0] == 4) {
				$time_elapsed = parent::timeElapsed();
				echo "AI cracked the code in {$i} rounds and {$time_elapsed}s!\n";
				return (array($i, $time_elapsed));
			}
		}	
		echo "AI took too much time and was discovered...\n";
		return (array($this->AILim, parent::timeElapsed()));
	}

	private function autoStatGame() {
		$rtot = 0;
		$rtime = 0;
		$err = 0;
		$win = 0;
		for ($i = 1; $i <= $this->nbGames; $i++)
		{
			list($round, $time) = $this->playAIGame();
			if ($round == $this->AILim) 
				$err++;
			else {
				$rtot += $round;
				$rtime += $time;
			}
			if ($round <= $this->round)
				$win++;
		}
		$i--;
		if ($err != $i) {
			$rtot /= $i - $err;
			$rtime /= $i - $err;
		}
		$pct = $win / $i * 100;
		echo "\nAverage: {$rtot} rounds, {$rtime}s\nfailed {$err} times..\nwon {$win} times i.e. {$pct}%\n";
	}

}

?>
