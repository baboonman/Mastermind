<?php

class Options 
{
	private $opt;

	public function __construct() {
		$shortOpt = "ha::n:l:";
		$longOpt = array("help", "auto::", "limite:");
		$this->opt = getopt($shortOpt, $longOpt);
		if ( isset($this->opt['h']) || isset($this->opt['help']) )
			$this->usage();
	}

	public function getOpts()
	{
		$gameRounds = 10;
		$AILim = 5040;
		$autoMode = false;
		$nbGames = 10;

		if ( isset($this->opt['n']) && ctype_digit($this->opt['n']) ) {
			$gameRounds = intVal($this->opt['n']);
		}
		if ( isset($this->opt['l']) && ctype_digit($this->opt['l']) ) {
			$AILim = intVal($this->opt['l']);
		}
		if ( isset($this->opt['a']) ) {
			$autoMode = true;
			if (ctype_digit($this->opt['a'])) {
				$nbGames = intVal($this->opt['a']);
			}
		}
		
		return array($gameRounds, $AILim, $autoMode, $nbGames);
	}

	private function usage()
	{
?>
Usage: ./master.php [options]

options:
	-h ; --help				Show help message
	-n			<rounds>	Defines the max number of turns to crack the code
							Default is 10
	-l			<rounds>	Defines the maximum number of rounds AI has to decrypt code
							Default is 5040
	-a			[=games]	Run auto mode AI vs AI, games defines number of games. 
							Default is 10
	All options values must be INT
<?php		
		exit(0);
	}

}
?>
