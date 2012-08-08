<?php
class shuoshuo{
	public $content='';
	private $sql;
	private $app_info;
	private $shuoshuo;
	private $error;
	public $config;
	function __construct($app_info=array()){
		global $sql;
		$this->sql=&$sql;
		$this->app_info=$app_info;
		$this->config=array();
		$this->get_config();
	}
	public function get_new_shuoshuo(){
		if($this->config['num']>4){
			$this->set_config('num',0);
			$this->shuoshuo=$this->sql->get_one_rand_shuoshuo($this->config['old']);
		}else{
			$this->set_config('num',$this->config['num']+1);
			$this->shuoshuo=$this->sql->get_one_rand_shuoshuo();
		}
		if($this->shuoshuo==false){
			$this->error='mysql result error';
			$this->show_error();
			return false;
		}
		$this->content=$this->shuoshuo['english'].', '.$this->shuoshuo['pt'].', '.$this->shuoshuo['chinese'];
		if(isset($this->app_info['name']) && !empty($this->app_info['name']))$this->content.='   ('.$this->app_info['name'].')';
	}
	public function flag_shuoshuo(){
		if(!$this->sql->up_sql_arr('word',array('flag'=>'1'),'`id`='.$this->shuoshuo['id']))$this->error='flag word fail';
		$this->show_error();
	}
	public function re_flag_shuoshuo(){
		if(!$this->sql->up_sql_arr('word',array('flag'=>'0'),'`id`='.$this->config['now']))$this->error='flag word fail';
		$this->show_error();
	}	
	public function count_next_shuoshuo(){
		if($this->config['num']>4 || rand()%5==0)$this->set_config('old',$this->config['now']);
		$this->set_config('now',$this->shuoshuo['id']);
		$this->set_config('time',time());
	}
	public function show_error(){
		if(!empty($this->error))die($this->error."\n");
	}
	private function get_config(){
		$s=$this->sql->get_config();
		foreach($s as $v){
			$this->config[$v['name']]=$v['value'];
		}
	}
	private function set_config($name,$value){
		if(!$this->sql->up_sql_arr('config',array('value'=>"$value"),"`name`='".$name."'"))echo "set $name config fail\n";
	}
}
?>