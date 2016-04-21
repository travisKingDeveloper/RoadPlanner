<?php
require_once 'lib/base.php';
class User extends Base {	
	var $_name='User';	
	var $_tbl='pms_users';	 
	var $_error=array();
	
		
	public function login($username=null,$pwd=null){
		if(HASH_FUNCTION=='md5'){
			$hashPwd =  md5($pwd); 
		}else if(HASH_FUNCTION=='sha1'){
			$hashPwd =  sha1($pwd);
		}
		$user = $this->find(array($this->_getUsernameField()=>"='".$username."'",$this->_getPasswordField()=>"='".$hashPwd."'"));
		if(sizeof($user)>0){
			//print_r($user);
			$_SESSION[$this->_getAccessSession()]=$user[0][$this->_name][$this->_getPrimaryKey()];
			return true;
		}else{
			return false;
		}
	}
	
	public function logout(){
		 session_destroy(); 
		 return true;
	}
	
	public function checkAccess(){
		if(!isset($_SESSION[$this->_getAccessSession()])){
			return false;
			
		}else {
			return true;
		}
	}
	
	
	public function getTbl(){		
		return INT_USER_TBL;
	}	
	
	private function _getUsernameField(){			
		return INT_USER_USR;
	}
	
	private function _getPasswordField(){
		return INT_USER_PWD;
	}
	
	private function _getAccessSession(){
		return INT_ACCESS_SESSION;		
	}

	private function _getPrimaryKey(){		
		return INT_USER_ID;
	}
}
?>
