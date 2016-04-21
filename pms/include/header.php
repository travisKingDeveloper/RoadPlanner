<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> Private Message System</title>
<meta name="keywords" content="">
<meta name="description" content="Private Message Syste">
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/pm.css">

<link rel="stylesheet" type="text/css" href="css/jquery.wysiwyg.css">
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/js.js"></script>

<script type="text/javascript">
  $(function()
  {
      $('#pmreplymessage').wysiwyg();
  });
  </script>


</head>
<body>
<div id="header">
</div>
<div id="nav">
Private Message System
<?php
if(isset($_SESSION[INT_ACCESS_SESSION])){
?>
<a href="index.php?logout">(Log out)</a>
<?php
}
?>
</div>
<div id="wrap" class="wrap with_side s_clear">
    <div class="main">
        <div class="content">
        
<?php 
 		if(isset($_SESSION['msg'])){
			echo '<div class="message-box '.$_SESSION['msg']['type'].'">';
			foreach($_SESSION['msg']['content'] as $cont){
				echo $cont.'<br/>';
			}			
			echo  '</div>';
			unset($_SESSION['msg']);
		}	
?>