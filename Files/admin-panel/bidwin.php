<?php
include ('include/header.php');
?>

</head>
<body>   
 <?php
include ('include/sidebar.php');
?>


    <div class="pageheader">
      <h2><i class="fa fa-gamepad"></i> BID NOW Make Win</h2>
    </div>

    <div class="contentpanel">

      <div class="row">

        <div class="col-md-12">
		
<center>
   
<?php

$gameid = $_GET["gid"];

$gamedetails = mysql_fetch_array(mysql_query("SELECT title, btext, op1, op2, op1s, op2s, status FROM bid_game WHERE id='".$gameid."'"));

if($_POST)
{

$sub = $_POST["sub"];
$winb = $_POST["winb"];

if($winb==""){
echo " <h4 style=\"color:red;\">Please Select Win Amount</h4>";
} else{

if($gamedetails[6] == 1){
echo " <h4 style=\"color:red;\">The Game is Expired Already!!!<br/>";
include("exit.php");
exit();
}
	

$res = mysql_query("UPDATE bid_game SET status='1', winop='".$sub."' WHERE id='".$gameid."'");


echo "<font style=\"font-size: 28px;font-style: bold;text-align: center;color:red;\">Result for $gamedetails[0] </font><br/><br/>";

if($res){

mysql_query("UPDATE bid_bid SET gstat='1' WHERE gid='".$gameid."'");



mysql_query("UPDATE bid_bid SET winstatus='1' WHERE gid='".$gameid."' and opid='".$sub."'");

//mysql_query("UPDATE seventrade_game SET sesh='".time()."' WHERE gid='".$running[0]."'");


if($sub == 0){
$ddaa = mysql_query("SELECT userid, id, amount FROM bid_bid WHERE gid='".$gameid."'");

}else{
$ddaa = mysql_query("SELECT userid, id, amount FROM bid_bid WHERE opid='".$sub."' AND gid='".$gameid."'");
}




while ($data = mysql_fetch_array($ddaa))
{
$name = mysql_fetch_array(mysql_query("SELECT username, email FROM users WHERE id='".$data[0]."'"));









///////////////////------------------------------------->>>>>>>>>Send Email

$to = "$name[1]";
$subject = 'Welcome to Lets Bid';

$message = 'Hi '."$name[0], \r\n YOU Win $gamedetails[0] ";

$headers = 'From: ' . "$sender \r\n" .
    'Reply-To: ' . "$sender \r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

///////////////////------------------------------------->>>>>>>>>Send Email





//////////---------------------------------------->>>> ADD THE BALANCE 
$willadd = $data[2]*$winb;

$ct = mysql_fetch_array(mysql_query("SELECT mallu FROM users WHERE id='".$data[0]."'"));
$ctn = $ct[0]+$willadd;

mysql_query("UPDATE users SET mallu='".$ctn."' WHERE id='".$data[0]."'");
echo "<font style=\"font-size: 18px;font-style: bold;text-align: center;color:green;\">$name[0]'s Balance Updated to $ctn </font><br/> ";
//////////---------------------------------------->>>> ADD THE BALANCE

//////////---------------------------------------->>>> TRX HISTORY
$tm = time();
mysql_query("INSERT INTO trx_history SET usid='".$data[0]."', des='Bid Winner For ".$gamedetails[0]."', sig='+', amount='".$willadd."', tm='".$tm."'");
//////////---------------------------------------->>>> TRX HISTORY



//////////---------------------------------------->>>> ADD THE BALANCE TO REF ID

$refid =  mysql_fetch_array(mysql_query("SELECT ref FROM users WHERE id='".$data[0]."'"));
$name = mysql_fetch_array(mysql_query("SELECT username FROM users WHERE id='".$refid[0]."'"));
$rct = mysql_fetch_array(mysql_query("SELECT mallu FROM users WHERE id='".$refid[0]."'"));
$rctn = $rct[0]+1;
mysql_query("UPDATE users SET mallu='".$rctn."' WHERE id='".$refid[0]."'");
echo "(Referrer $name[0]'s Balance Updated $rct[0] to  $rctn)<br/><br/>";

$dt = date("Y-m-d H:i:s", time());

mysql_query("UPDATE bid_bid SET winaff='1' WHERE id='".$data[1]."'");


//////////---------------------------------------->>>> ADD THE BALANCE


//////////---------------------------------------->>>> TRX HISTORY
$kida =  mysql_fetch_array(mysql_query("SELECT username FROM users WHERE id='".$data[0]."'"));
$tm = time();
mysql_query("INSERT INTO trx_history SET usid='".$refid[0]."', des='Bid Winner Affiliate Bonus for ".$kida[0]."', sig='+', amount='1', tm='".$tm."'");
//////////---------------------------------------->>>> TRX HISTORY


}


}else{
echo "<h1>Some problem occur....</h1><br/>Please Try again. <br/><br/>";
}

	
	
	
	
}



}




$gamedetails = mysql_fetch_array(mysql_query("SELECT title, btext, op1, op2, op1s, op2s, status FROM bid_game WHERE id='".$gameid."'"));





echo "<h1>$gamedetails[0]</h1>";
echo "<p>$gamedetails[1]</9>";

$op1 = mysql_query("SELECT amount FROM bid_bid WHERE gid='".$gameid."' AND opid='1' ORDER BY id");
$co1 = 0;
$ci1 = 0;
    while ($oo1 = mysql_fetch_array($op1))
    {
$co1 = $co1+$oo1[0];
$ci1++;
}

$op2 = mysql_query("SELECT amount FROM bid_bid WHERE gid='".$gameid."' AND opid='2' ORDER BY id");
$co2 = 0;
$ci2 = 0;
    while ($oo2 = mysql_fetch_array($op2))
    {
$co2 = $co2+$oo2[0];
$ci2++;
}


echo "<form action=\"\" method=\"post\">";

?>


<div class="col-sm-12">

            <div class="form-group">
					
					
<h3>Win Amount <input type="text" style="width: 200px;" name="winb"/>  2 for 200%</h3> 

<br/><br/>

<?php



echo "<button type=\"submit\" name=\"sub\" value=\"1\" class=\"btn btn-primary btn-lg\">$gamedetails[2] ($ci1 bid - $co1 coin) </button>  &nbsp; &nbsp; &nbsp; &nbsp; ";

echo "<button type=\"submit\" name=\"sub\" value=\"0\" class=\"btn btn-danger btn-lg\">DRAW</button>  &nbsp; &nbsp; &nbsp; &nbsp; ";

echo "  <button type=\"submit\" name=\"sub\" value=\"2\" class=\"btn btn-primary btn-lg\">$gamedetails[3] ( $ci2 bid - $co2 coin) </button>";
?>


</div>
</form>










          </center>      
		  
		  
		  
		  </div><div class="col-sm-3"></div>
		       
			   
			   
			   
			   </div><!-- col-sm-6 -->

        
        

        
      </div><!-- row -->

      
      
      
    </div><!-- contentpanel -->

  </div><!-- mainpanel -->

  


</section>


<?php
 include ('include/footer.php');
 ?>
 <script>
 	  // Spinner
  var spinner = jQuery('#spinner').spinner();
  spinner.spinner('value', 0);
  </script>
</body>
</html>