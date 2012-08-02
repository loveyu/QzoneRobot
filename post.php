<?php
class Post{
	private $url="http://blog30.z.qq.com/mood/mood_add_exe.jsp?sid=";
	private $account;
	public $status=FALSE;
	private $error='no config';
	function __construct($account=array()){
		if(!isset($account['B_UID']) || !isset($account['sid']))$this->error='account config error';
		else $this->error='';
		$this->account=$account;
	}
	public function SendPost($content){
		if($content==false || empty($content))$this->error='shuoshuo content is empty';
		$this->status=$this->POST($content);
		if(!$this->status)$this->error='POST Result Fail!';
	}
	private function POST($content){
		if($this->error!='')$this->Show_error();
		$data=array(
			'content' => $content,
			'B_UID' => $this->account['B_UID'],
			'action' => '1',
					);
		$options = array('http'=>array(
			'method'=>"POST",
			'header'=>
				"Content-type: application/x-www-form-urlencoded\r\n",
				'content'=>http_build_query($data)//http_build_query是把数组转换为字符传的形式.结果形式：ms=BE&iso=BE&vat=0462569145&BtnSubmitVat=Verify,版本为php5才有
		));
		$context = stream_context_create($options);
		$content = file_get_contents($this->url.$this->account['sid'], false, $context);
		if(strstr($content,'发表成功!')==FALSE)return FALSE;
		else return TRUE;
	}
	private function Show_error(){
		die($this->error."\n");
	}
}
?>