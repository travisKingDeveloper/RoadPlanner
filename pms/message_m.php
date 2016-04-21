<?php
require_once 'lib/base.php';
require_once 'user_m.php';
class Message extends Base {	
	protected $_name='Message';	
	protected $_tbl='pms_messages';	 
	protected $_error=array();
	
	protected $_max=0;
	
	//get messages 
	public function getMyMsg($uid=null,$offset,$rowsPerPage,$type){
		//get results
		if('index'==$type){
			$sql = 'SELECT * FROM '.$this->getTbl(). ' WHERE  (receiver_id='.$uid.' OR sender_id='.$uid.')'.
						' AND belong_to = '.$uid.' ORDER BY date DESC LIMIT '.$offset.','.$rowsPerPage;
		}else if('sent'==$type){
			$sql = 'SELECT * FROM '.$this->getTbl(). ' WHERE  (sender_id='.$uid.')'.
						' AND belong_to = '.$uid.' ORDER BY date DESC LIMIT '.$offset.','.$rowsPerPage;
		}else if ('received'==$type){
			$sql = 'SELECT * FROM '.$this->getTbl(). ' WHERE  (receiver_id='.$uid.')'.
						' AND belong_to = '.$uid.' ORDER BY date DESC LIMIT '.$offset.','.$rowsPerPage;
		}
		
		
		$result=$this->query($sql);
		$msgs = $this->__formatData($result);
		
		//get max
		if('index'==$type){
			$sql = 'SELECT count(*) FROM '.$this->getTbl(). ' WHERE  (receiver_id='.$uid.' OR sender_id='.$uid.')'.
							' AND belong_to = '.$uid;
		}else if('sent'==$type){
			$sql = 'SELECT count(*) FROM '.$this->getTbl(). ' WHERE  (sender_id='.$uid.')'.
							' AND belong_to = '.$uid;
		}else if('received'==$type){
			$sql = 'SELECT count(*) FROM '.$this->getTbl(). ' WHERE  (receiver_id='.$uid.')'.
							' AND belong_to = '.$uid;
		}
		
		
		$result=$this->query($sql);
		$max=$this->__formatData($result);
		$this->_max=$max[0]['Message']['count(*)'];		
		
		//get user info
		if($msgs!=null){
			foreach($msgs as &$msg){
				//print_r($msg);
				if($msg['Message']['receiver_id']==$uid){
					$usr=$this->getUserInfo($msg['Message']['sender_id']);
				}else{
					$usr=$this->getUserInfo($msg['Message']['receiver_id']);
				}
				$msg['User']=$usr[0]['User'];			
			}		
		}
		//print_r($msgs);
		//print_r($this->_max);
		return $msgs;
	}	
	
	public function getMax(){
		return $this->_max;
	}
	
	//get a message tree
	public function getMsgTree($id=null){
		$thisMsg=$this->find(array('id'=>'='.$id,'belong_to'=>'='.$_SESSION[INT_ACCESS_SESSION] ));
		
		if($thisMsg[0]['Message']['sender_id']==$_SESSION[INT_ACCESS_SESSION]){
			$sql='SELECT * FROM '.$this->getTbl(). ' WHERE  1 = 1 '.'  AND '.' belong_to='.$_SESSION[INT_ACCESS_SESSION].
					' AND ('.'receiver_id='.$thisMsg[0]['Message']['receiver_id'].' OR sender_id='.$thisMsg[0]['Message']['receiver_id'].') ORDER BY date DESC'; 
		}else{
			$sql='SELECT * FROM '.$this->getTbl(). ' WHERE  1 = 1 '.'  AND '.' belong_to='.$_SESSION[INT_ACCESS_SESSION].
					' AND ('.'receiver_id='.$thisMsg[0]['Message']['sender_id'].' OR sender_id='.$thisMsg[0]['Message']['sender_id'].') ORDER BY date DESC'; 
		}
		
		
		$result=$this->query($sql);
		$allMsgs =$this->__formatData($result);
		
		//get user info
		foreach($allMsgs as &$msg){
			$usr=$this->getUserInfo($msg['Message']['sender_id']);
			$msg['User']=$usr[0]['User'];			
		}	
		
		return 	$allMsgs;
	}
	
	public function getMsg($id=null){
		$msg=$this->find(array('id'=>'='.$id,'belong_to'=>'='.$_SESSION[INT_ACCESS_SESSION] ));
		$usr=$this->getUserInfo($msg[0]['Message']['sender_id']);
		$msg[0]['User']=$usr[0]['User'];	
		return $msg;
	}
	
	public function getUserInfo($userId){
		//user table
		$user = new User();
		return $user->find(array(INT_USER_ID=>'='.$userId));
	}
	
	public function getToUser($id=null){
		$thisMsg=$this->find(array('id'=>'='.$id,'belong_to'=>'='.$_SESSION[INT_ACCESS_SESSION] ));
		if($thisMsg[0]['Message']['sender_id']==$_SESSION[INT_ACCESS_SESSION]){
			return $thisMsg[0]['Message']['receiver_id'];
		}else{
			return $thisMsg[0]['Message']['sender_id'];
		}
	}
	
	public function validate($message){
			if($message['Message']['sender_id']==$message['Message']['receiver_id']){
				return "You can not send a message to yourself";
			}else if(null==$message['Message']['content']||''==trim($message['Message']['content'])){
				return "Please fill in your message";
			}else{
				return '1';
			}
	}
	
	public function deleteMsgs($ids){
		foreach($ids as $id){
			//validate
			$thisMsg=$this->find(array('id'=>'='.$id));
			if($thisMsg[0]['Message']['belong_to']==$_SESSION[INT_ACCESS_SESSION]){
				//$sql = 'DELETE FROM '.$this->getTbl().' WHERE 1=1 '.'  AND '.' belong_to='.$_SESSION[INT_ACCESS_SESSION].
					//				' AND ((receiver_id='.$thisMsg[0]['Message']['receiver_id'].' AND sender_id='.$thisMsg[0]['Message']['sender_id'].')'.
					//				' OR (receiver_id='.$thisMsg[0]['Message']['sender_id'].' AND sender_id='.$thisMsg[0]['Message']['receiver_id'].'))';
				$sql = 'DELETE FROM '.$this->getTbl().' WHERE 1=1 '.'  AND '.' belong_to='.$_SESSION[INT_ACCESS_SESSION].
									' AND id ='.$id;
				$result=$this->query($sql);	
			}else {
				return 'This message dose not belong to you';
			}
		}
		
		return '1';
	}
	
}
?>
