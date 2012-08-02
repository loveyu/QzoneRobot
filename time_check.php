<?php
class time_check{
	private $sql;
	private $shuoshuo;
	private $config;
	function __construct($config){
		global $sql,$shuoshuo;
		$this->sql=&$sql;
		$this->shuoshuo=&$shuoshuo;
		$this->config=$config;
		$this->check();
	}
	private function check(){
		if($this->shuoshuo->config['time']+$this->count_time()>time() || date("H")<6)exit;
	}
	private function count_time(){
		return ($this->config['h']*60+$this->config['i'])*60+$this->config['s'];
	}
}
?>