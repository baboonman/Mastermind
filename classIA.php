<?php

class			IA
{
	private		$inNum;
	private		$exDig;

	public function __construct( $role ) {
		if ($role == "att") {
			$this->inNum = array(0,1,2,3,4,5,6,7,8,9);
			$this->exDig = array(array(), array(),array(),array());	
		}
	}

	public function randCode() 
	{
		$code = array(-1,-1,-1,-1);
		$tab = array(0,1,2,3,4,5,6,7,8,9);
		$len = 9;
		for ($i = 0 ; $i < 4 ; $i++) {
			$rand =rand(0, $len); 
			$tmp = array_splice($tab, $rand, 1);
			$code[$i] = $tmp[0]; 
			$len --;			
		}	
		return $code; 
	}
	
	public function computeTry() 
	{
		$code = array(-1,-1,-1,-1);
		for ($i = 0 ; $i < 4 ; $i++) {
			$tab = array_diff($this->inNum, $this->exDig[$i], $code);
			$len = count($tab) - 1;
			$rand =rand(0, $len); 
			$tmp = array_splice($tab, $rand, 1);
			if (!isset($tmp[0]))
				$tmp[] = 0;
			$code[$i] = $tmp[0]; 
		}	
		return $code; 
	}	

	public function computeRes( $try, $res )
	{
		if ( ($res[0] + $res[1]) == 4 ) {
			$this->inNum = $try;
		}
		else if ( $res[0] == 0 ) {
			for ($i = 0 ; $i < 4 ; $i++) {
				$this->exDig[$i][] = $try[$i];
			}
			if ( $res[1] == 0 ) {
				$this->inNum = array_diff($this->inNum, $try);
			}
		}
	}

	public function debug( $str = null)
	{
		echo "debug {$str}:\n";
		$str_inNum = implode(",", $this->inNum);
		$str_exDig0 = implode(",", $this->exDig[0]);
		$str_exDig1 = implode(",", $this->exDig[1]);
		$str_exDig2 = implode(",", $this->exDig[2]);
		$str_exDig3 = implode(",", $this->exDig[3]);
		echo "inNum : {$str_inNum}\n
				exDig0 : {$str_exDig0}\n
				exDig1 : {$str_exDig1}\n
				exDig2 : {$str_exDig2}\n
				exDig3 : {$str_exDig3}\n";
	}

}

?>
