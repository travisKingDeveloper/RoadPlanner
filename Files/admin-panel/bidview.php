<?php
include ('include/header.php');
?>

  
  <link href="css/style.default.css" rel="stylesheet">
  <link href="css/jquery.datatables.css" rel="stylesheet">
</head>
<body>   
 <?php
include ('include/sidebar.php');
?>

    <div class="pageheader">
      <h2><i class="fa fa-th-list"></i> View BID GAMES</h2>
    </div>

    
    <div class="contentpanel">
	 <div class="panel panel-default">

        <div class="panel-body">
		
		 <div class="clearfix mb30"></div>
		 
		 
<?php
if($_POST)
{
$gameid = $_POST["gameid"];
$action = $_POST["action"];
$opt = $_POST["opt"];

echo "$gameid - $action - $opt";

$res = mysql_query("UPDATE bid_game SET $opt='".$action."' WHERE id='".$gameid."'");

if($res){
	echo "<div class=\"alert alert-success alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

UPDATED Successfully!

</div>";
}else{
	echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
}

}

?>
				
				
				
				
          <div class="table-responsive">
          <table class="table table-striped" id="table2">
              <thead>
                 <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Option 1</th>
                    <th>Option 1</th>
                    <th>Option 1</th>
                    <th>Option 2</th>
                    <th>Option 2</th>
                    <th>Option 2</th>
                    <th>Status</th>
                    
					</tr>
              </thead>
              <tbody>
                
				
				<?php

$ddaa = mysql_query("SELECT id, title, btext, op1, op2, op1s, op2s, status FROM bid_game ORDER BY id");
    echo mysql_error();
    while ($data = mysql_fetch_array($ddaa))
    {



$op1 = mysql_query("SELECT amount FROM bid_bid WHERE gid='".$data[0]."' AND opid='1' ORDER BY id");
$co1 = 0;
$ci1 = 0;
    while ($oo1 = mysql_fetch_array($op1))
    {
$co1 = $co1+$oo1[0];
$ci1++;
}

$op2 = mysql_query("SELECT amount FROM bid_bid WHERE gid='".$data[0]."' AND opid='2' ORDER BY id");
$co2 = 0;
$ci2 = 0;
    while ($oo2 = mysql_fetch_array($op2))
    {
$co2 = $co2+$oo2[0];
$ci2++;
}





$dummy = "<button class=\"btn btn-info btn-xs\">$ci1 bid - $co1 coin</button>";

////-------------->>> Option 1 
////// 0 = on ////// \\\\\ 1 = off ///\\\\\

if($data[5]==0){
$opp1 = "
<form action=\"\" method=\"post\">
<input type=\"hidden\" name=\"gameid\" value=\"$data[0]\">
<input type=\"hidden\" name=\"action\" value=\"1\">
<input type=\"hidden\" name=\"opt\" value=\"op1s\">

<button class=\"btn btn-success btn-xs\">ON</button>
</form>
";
}else{
	
$opp1 = "
<form action=\"\" method=\"post\">
<input type=\"hidden\" name=\"gameid\" value=\"$data[0]\">
<input type=\"hidden\" name=\"action\" value=\"0\">
<input type=\"hidden\" name=\"opt\" value=\"op1s\">

<button class=\"btn btn-danger btn-xs\">OFF</button>
</form>
";

}
////-------------->>> Option 1 

////-------------->>> Option 2
if($data[6]==0){
	
$opp2 = "
<form action=\"\" method=\"post\">
<input type=\"hidden\" name=\"gameid\" value=\"$data[0]\">
<input type=\"hidden\" name=\"action\" value=\"1\">
<input type=\"hidden\" name=\"opt\" value=\"op2s\">

<button class=\"btn btn-success btn-xs\">ON</button>
</form>
";
}else{
	$opp2 = "
<form action=\"\" method=\"post\">
<input type=\"hidden\" name=\"gameid\" value=\"$data[0]\">
<input type=\"hidden\" name=\"action\" value=\"0\">
<input type=\"hidden\" name=\"opt\" value=\"op2s\">

<button class=\"btn btn-danger btn-xs\">OFF</button>
</form>
";

}
////-------------->>> Option 2 


if($data[7]==0){
	$runn = "<a href=\"bidwin.php?gid=$data[0]\" class=\"btn btn-success btn-xs\"> Running... </a>";
}else{

	$runn = "<button class=\"btn btn-danger-alt btn-xs\">Expired</button>";
}

 echo "                                 <tr>
                                            <td>$data[0]</td>
                                            <td>$data[1]</td>
                                            <td>$data[3]</td>
                                            <td><button class=\"btn btn-info btn-xs\">$ci1 bid - $co1 coin</button></td>
                                            <td>$opp1</td>
                                            <td>$data[4]</td>
                                            <td><button class=\"btn btn-info btn-xs\">$ci2 bid - $co2 coin</button></td>
                                            <td>$opp2</td>
                                            <td>$runn </td>

                                        </tr>
	";
	}
?>
				
				
			
				




				
				 
              </tbody>
           </table>
          </div><!-- table-responsive -->
		  
        </div>
      </div>
                  
      

      
    </div><!-- contentpanel -->
    


  
</section>


<?php
 include ('include/footer.php');
 ?>

<script src="js/jquery.datatables.min.js"></script>
<script src="js/select2.min.js"></script>

<script>
  jQuery(document).ready(function() {
    
    "use strict";
    
    jQuery('#table1').dataTable();
    
    jQuery('#table2').dataTable({
      "sPaginationType": "full_numbers"
    });
    
    // Select2
    jQuery('select').select2({
        minimumResultsForSearch: -1
    });
    
    jQuery('select').removeClass('form-control');
    
    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var c = confirm("Continue delete?");
      if(c)
        jQuery(this).closest('tr').fadeOut(function(){
          jQuery(this).remove();
        });
        
        return false;
    });
    
    // Show aciton upon row hover
    jQuery('.table-hidaction tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });
  
  
  });
</script>



</body>
</html>



