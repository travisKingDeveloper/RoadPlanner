<?php
include 'integration.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$qs = isset($_SERVER['REDIRECT_QUERY_STRING']) ? $_SERVER['REDIRECT_QUERY_STRING'] : $_SERVER['QUERY_STRING'];

$action = 'login';
$tokens = explode( '&', $qs );
if ( strlen( $tokens[0] ) > 0 ) {
	$action = strtolower( $tokens[0] );
}

session_start();
if(''!=$action&&'login'!=$action&&'logout'!=$action){
	require_once 'user_m.php';
	$checker= new User();
	if(!$checker->checkAccess()){
		header( 'Location: index.php');
	}	
}

switch( $action ) {
	case 'index':
		require_once 'message_m.php';
		$message = new Message();
			$_SESSION['PMS_PAGE']='index';
		//pagination
			$rowsPerPage=5;
			// by default we show first page
			$pageNum = 1;			
			// if $_GET['page'] defined, use it as page number
			if(isset($_GET['page']))
			{
			$pageNum = $_GET['page'];
			}
		 	// counting the offset
			$offset = ($pageNum - 1) * $rowsPerPage;
			$msgs = $message->getMyMsg($_SESSION[INT_ACCESS_SESSION],$offset,$rowsPerPage,'index');
			$numrows=$message->getMax();
			// how many pages we have when using paging?
			$maxPage = ceil($numrows/$rowsPerPage);
			$self = $_SERVER['PHP_SELF'].'?index';
		
		//print_r($msgs);
		include 'include/header.php';
		include 'message_index.php';
		include 'include/footer.php';
	break;
	case 'index_sent':
		require_once 'message_m.php';
		$message = new Message();
			$_SESSION['PMS_PAGE']='index_sent';
		//pagination
			$rowsPerPage=5;
			// by default we show first page
			$pageNum = 1;			
			// if $_GET['page'] defined, use it as page number
			if(isset($_GET['page']))
			{
			$pageNum = $_GET['page'];
			}
		 	// counting the offset
			$offset = ($pageNum - 1) * $rowsPerPage;
			$msgs = $message->getMyMsg($_SESSION[INT_ACCESS_SESSION],$offset,$rowsPerPage,'sent');
			$numrows=$message->getMax();
			// how many pages we have when using paging?
			$maxPage = ceil($numrows/$rowsPerPage);
			$self = $_SERVER['PHP_SELF'].'?index';
		
		//print_r($msgs);
		include 'include/header.php';
		include 'message_index_sent.php';
		include 'include/footer.php';
	break;
	case 'index_received':
		require_once 'message_m.php';
		$message = new Message();
			$_SESSION['PMS_PAGE']='index_received';
		//pagination
			$rowsPerPage=5;
			// by default we show first page
			$pageNum = 1;			
			// if $_GET['page'] defined, use it as page number
			if(isset($_GET['page']))
			{
			$pageNum = $_GET['page'];
			}
		 	// counting the offset
			$offset = ($pageNum - 1) * $rowsPerPage;
			$msgs = $message->getMyMsg($_SESSION[INT_ACCESS_SESSION],$offset,$rowsPerPage,'received');
			$numrows=$message->getMax();
			// how many pages we have when using paging?
			$maxPage = ceil($numrows/$rowsPerPage);
			$self = $_SERVER['PHP_SELF'].'?index';
		
		//print_r($msgs);
		include 'include/header.php';
		include 'message_index_received.php';
		include 'include/footer.php';
	break;
	case 'login':
		require_once 'user_m.php';
		$user = new User();
		
		
		//autologin
		if($user->checkAccess()){
			header( 'Location: index.php?index');
		}
		
		
		//view
		if(!isset($_POST['post'])){	
			include 'include/header.php';
			include 'user_login.php';
			include 'include/footer.php';
		//login
		}else{		
			//login successfully
			if($user->login($_POST['username'],$_POST['password'])){
				header( 'Location: index.php?index');
			//login failure
			}else {				
				$_SESSION['msg']['type']='error';
				$_SESSION['msg']['content']=array('Invalid username or password');
				
				header( 'Location: index.php?login');
			}
				
		}
	break;
	case 'logout':
		require_once 'user_m.php';
		$user = new User();
		if($user->logout()){
			header( 'Location: index.php');
		}
	break;
	case 'view':
		require_once 'message_m.php';
		$message = new Message();		
		
		$msgs = $message->getMsgTree($_GET['id']);
		$toUser = $message->getToUser($_GET['id']);
		$hiddenView = $_GET['id'];
		
		$user = new User();	
		$with = $user->find(array(INT_USER_ID=>'='.$toUser));
		
		include 'include/header.php';
		include 'message_view.php';
		include 'include/footer.php';
	break;
	case 'read':
		require_once 'message_m.php';
		$message = new Message();		
		
		$msg = $message->getMsg($_GET['id']);
		$toUser = $message->getToUser($_GET['id']);
		
		
		$user = new User();	
		$with = $user->find(array(INT_USER_ID=>'='.$toUser));
		
		include 'include/header.php';
		include 'message_read.php';
		include 'include/footer.php';
	break;
	case 'reply':
		require_once 'message_m.php';
		$message = new Message();
		$save['Message']['sender_id']= $_SESSION[INT_ACCESS_SESSION];
		$save['Message']['receiver_id']= $_POST['receiver_id'];
		$save['Message']['content']=$_POST['message'];
		$save['Message']['date']= date("Y-m-d H:i:s");         
		$save['Message']['is_read']=0;
		$save['Message']['belong_to']=$_SESSION[INT_ACCESS_SESSION];
		
		$saveT['Message']['sender_id']= $_SESSION[INT_ACCESS_SESSION];
		$saveT['Message']['receiver_id']= $_POST['receiver_id'];
		$saveT['Message']['content']=$_POST['message'];
		$saveT['Message']['date']= date("Y-m-d H:i:s");         
		$saveT['Message']['is_read']=0;
		$saveT['Message']['belong_to']=$_POST['receiver_id'];
		
		
		$valid=$message->validate($save);
		if('1'==$valid){
			$message->save($save['Message']);
			$message->save($saveT['Message']);
			
			$_SESSION['msg']['type']='ok';
			$_SESSION['msg']['content']=array('Message has been sent');
		}else {
			//echo 'b';
			$_SESSION['msg']['type']='error';
			$_SESSION['msg']['content']=array($valid);
		}		
		header( 'Location: index.php?view&id='.$_POST['id']);		
	break;
	case 'send':
		require_once 'user_m.php';
		require_once 'message_m.php';
		$user = new User();
		$message = new Message();
		
		//view
		if(!isset($_POST['post'])){	
			$users = $user->find();
			include 'include/header.php';
			include 'message_send.php';
			include 'include/footer.php';
		//send
		}else{		
			$save['Message']['sender_id']= $_SESSION[INT_ACCESS_SESSION];
			$save['Message']['receiver_id']= $_POST['receiver_id'];
			$save['Message']['content']=$_POST['message'];
			$save['Message']['date']= date("Y-m-d H:i:s");         
			$save['Message']['is_read']=0;
			$save['Message']['belong_to']=$_SESSION[INT_ACCESS_SESSION];
			
			//receiver record
			$saveT['Message']['sender_id']= $_SESSION[INT_ACCESS_SESSION];
			$saveT['Message']['receiver_id']= $_POST['receiver_id'];
			$saveT['Message']['content']=$_POST['message'];
			$saveT['Message']['date']= date("Y-m-d H:i:s");         
			$saveT['Message']['is_read']=0;
			$saveT['Message']['belong_to']=$_POST['receiver_id'];
		
			$valid=$message->validate($save);
			if('1'==$valid){
				$message->save($save['Message']);
				$message->save($saveT['Message']);
				$_SESSION['msg']['type']='ok';
				$_SESSION['msg']['content']=array('Message has been sent');
				
				header( 'Location: index.php?index');		
			}else {			
				$_SESSION['msg']['type']='error';
				$_SESSION['msg']['content']=array($valid);
				
				header( 'Location: index.php?send');		
			}	
		}		
	break;
	case 'delete':
		require_once 'message_m.php';
		$message = new Message();
		
		if(isset($_POST['mid'])){
			$valid=$message->deleteMsgs($_POST['mid']);
		}else{
			$valid='Please select messages to delete';
		}
		
		if('1'===$valid){
			$_SESSION['msg']['type']='ok';
			$_SESSION['msg']['content']=array('Message(s) has(have) been deleted');
				
			header( 'Location: index.php?index');	
		}else {
			$_SESSION['msg']['type']='error';
			$_SESSION['msg']['content']=array($valid);
			
			header( 'Location: index.php?index');	
		}
		
		
	break;
	default:
		header( 'Location: index.php?index');
	break;		
}
?>