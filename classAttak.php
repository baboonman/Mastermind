<?php

require_once("classIA.php");

class			Attak		extends IA
{
	private		$side;

	public function __construct( $side = 0, $verbose = true ) {
		parent::__construct("att");
		$this->side = $side;
		if ($side && $verbose) {
			echo "AI is attack\n";
		}
		else if ($verbose) {
			echo "Player is attack\n";
		}
	}

	public function getTry() {
		if ($this->side) {
			return parent::computeTry();
		}
		else {
			return $this->enterTry();
		}
	}

	private function enterTry() {
		while (1) {
			echo "enter try: ";
			$code = trim(fgets(STDIN));
			if (strlen($code) == 4) {
				$code = (string)$code;
				return array($code[0], $code[1], $code[2], $code[3]);
			}
			else
				echo "must be a 4 digit code\n";
		}		
	}

	public function computeRes( $try, $res )
	{
		if ($this->side) 
			parent::computeRes($try, $res);
	}

}

?>
