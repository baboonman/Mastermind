<?php

class Timer 
{
	private	$time;
	private $time_float;
	private static $chronos;

	public function __construct() {
		$this->refreshTime();
	}

	private function microtime_float()
	{
   	 	list($usec, $sec) = explode(" ", microtime());
    	return ((float)$usec + (float)$sec);
	}

	public function refreshTime()
	{
		$this->time = microtime();
		$this->time_float = $this->microtime_float();
		self::$chronos = $this->time_float;
	}

	public function timeElapsed()
	{
		$now = $this->microtime_float();
		$elapsed = $now - self::$chronos;
		return ($elapsed);
	}

	public function showTime() 
	{
		$this->refreshTime();
		echo "Time is: {$this->time}\n";
		echo "Time float is: {$this->time_float}\n";
	}

}

?>
