<?php

require_once("classIA.php");

class			Defense		extends	IA
{
	private		$code = array(-1, -1, -1, -1);
	private		$side;

	public function __construct( $side = 0, $verbose = true ) {
		parent::__construct("def");
		if ($side) {
			if ($verbose)
				echo "AI is defense\n";
			$this->code = parent::randCode();
			#$this->code = array(3, 4, 5, 0);
		}
		else {
			if ($verbose)
				echo "Player is defense\n";
			$this->getCode();
		}
	}

	private function getCode() {
		$num = array('first ', 'second', 'third ', 'fourth');
		$i = 0;
		while ($i < 4) {
			echo "Enter the ". $num[$i] ." digit of your code: ";
			$digit = intval(trim(fgets(STDIN)));
			if (($digit >= 0 && $digit < 10) && (in_array( $digit, $this->code) == false)) {
				$this->code[$i] = $digit;
				$i++;
			}
			else {
				echo "All your digit have to be different\n";
			}
		}
	}
	
	public function getPassCode() {
		$code = "";
		$code .= (string)$this->code[0];
		$code .= (string)$this->code[1];
		$code .= (string)$this->code[2];
		$code .= (string)$this->code[3];
		return $code;
	}

	public function checkTry( $try, $verbose = true ) {
		$good = 0;
		$bad = 0;
		for ($i = 0; $i < 4; $i++) {
			if ( in_array($try[$i], $this->code) && $try[$i] == $this->code[$i] )
				$good++;
			else if ( in_array($try[$i], $this->code) && $try[$i] != $this->code[$i] )
				$bad++;
		}
		if ($verbose) {
			echo $good . " digit are the right colors and in the good spot.\n";
			echo $bad . " digit are the right colors but misplaced.\n";
		}
		return array($good, $bad);
	}
	
}

?>
