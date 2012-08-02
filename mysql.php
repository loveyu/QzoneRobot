<?php
function db_mysql_query($sql){
	$GLOBALS['QueryCount']++;
    return mysql_query($sql);
}
$QueryCount = 0;//统计数据库查询次数
class mysql{
	var $db_rp;
	private $db;
	private $db_charset;
	var $mysql_err;
	/** 初始化数据连接 */
	function __construct($mysql_info=array()){
		$hostname=$mysql_info['hostname'];
		$username=$mysql_info['username'];
		$password=$mysql_info['password'];
		$db=$mysql_info['db'];
		$dbcharset=$mysql_info['dbcharset'];
		$dbrp=$mysql_info['dbrp'];
		$mysql_con=mysql_connect($hostname,$username,$password);
		$this->db_rp=$dbrp;
		$this->db=$db;
		$this->deb_charset=$dbcharset;
		if(!$mysql_con)die("无法链接数据库:".mysql_error());
		mysql_query("SET NAMES '$dbcharset'");
		mysql_query("SET CHARACTER_SET_CLIENT=$dbcharset");
		mysql_query("SET CHARACTER_SET_RESULTS=$dbcharset");		
/*		db_mysql_query("SET NAMES '$dbcharset'");
		db_mysql_query("SET CHARACTER_SET_CLIENT=$dbcharset");
		db_mysql_query("SET CHARACTER_SET_RESULTS=$dbcharset");
*/
		if(!mysql_select_db($db,$mysql_con))
			die("无法选择数据库，或数据库".$db."不存在:".mysql_error());
		$this->where=array();
	}
	public function query($sql){
		return db_mysql_query($sql);
	}
	public function get_one_rand_shuoshuo(){
		$sql='SELECT * FROM '.$this->db_rp.'`word` WHERE `flag`=0 ORDER BY rand() LIMIT 1';
		$result=db_mysql_query($sql);
		$s=mysql_fetch_array($result);
		if($s['id']>0)return $s;
		else {
			$this->rest_word();
			return false;
		}
	}
	private function rest_word(){
		$sql="UPDATE `".$this->db_rp."word` SET `flag`=0 WHERE 1";
		db_mysql_query($sql);
	}
	public function up_sql_arr($table,$name_value,$while=1){
		$setStr=null;
		foreach($name_value as $name =>$value){
			$setStr.="`".$name."`='".$value."',";
		}
		$setStr=substr($setStr,0,-1);
		$sql="UPDATE `".$this->db_rp.$table."` SET $setStr WHERE ".$while;
		if(!db_mysql_query($sql))return false;
		return true;
	}
	public function get_config(){
		$sql="SELECT * FROM `".$this->db_rp."config`";
		return $this->sql_to_arr($sql);
	}
	private function sql_to_arr($sql){
		$return=array();
		$result = db_mysql_query($sql);
		$i=0;
		while($row = mysql_fetch_array($result)){
			$j=0;
			foreach($row as $name => $value)unset($row[$j++]);
			$return[$i]=$row;
			$i++;
		}
		return $return;	
	}
}
?>