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
      <h2><i class="fa fa-dollar"></i> Add Balance</h2>
    </div>

    
    <div class="contentpanel">
	
	
	
	<div class="row">

        <div class="col-md-12">
		
		
		
		<?php

if($_POST)
{

$iidd = $_POST["iidd"];
$sub = $_POST["sub"];

//echo "$iidd $sub";

$data = mysql_fetch_array(mysql_query("SELECT usid, amount, via, too, frm, trx, status FROM add_bal WHERE id='".$iidd."'"));

if($sub==1){
		
$res = mysql_query("UPDATE add_bal SET status='1' WHERE id='".$iidd."'");
if($res){


//////////---------------------------------------->>>> ADD THE BALANCE 
$willadd = $data[1];

$ct = mysql_fetch_array(mysql_query("SELECT mallu FROM users WHERE id='".$data[0]."'"));
$ctn = $ct[0]+$willadd;

mysql_query("UPDATE users SET mallu='".$ctn."' WHERE id='".$data[0]."'");
//echo "<font style=\"font-size: 18px;font-style: bold;text-align: center;color:green;\">Balance Updated to $ctn </font><br/> ";
//////////---------------------------------------->>>> ADD THE BALANCE

//////////---------------------------------------->>>> TRX HISTORY
$tm = time();
mysql_query("INSERT INTO trx_history SET usid='".$data[0]."', des='Add Balance Via ".$data[2]."', sig='+', amount='".$willadd."', tm='".$tm."'");
//////////---------------------------------------->>>> TRX HISTORY

echo "<div class=\"alert alert-success alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	
Balance Added Successfully!
</div>";
}else{
	echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
}
	
}else if($sub==9){
		
$res = mysql_query("UPDATE add_bal SET status='9' WHERE id='".$iidd."'");
if($res){

echo "<div class=\"alert alert-success alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	
Cancelled Successfully!
</div>";
}else{
	echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
}
	
}else{
		echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
	
}

}
?>
		
		
		
		
 
		  
		  
			   
			   
			   
			   </div><!-- col-sm-6 -->

        
        

        
      </div><!-- row -->
	
	
	
	
	
	
	 <div class="panel panel-default">

        <div class="panel-body">
		
		 <div class="clearfix mb30"></div>
		 
				
				
				
				
          <div class="table-responsive">
          <table class="table table-striped" id="table2">
              <thead>
                 <tr>

                    <th>Payment Via</th>
                    <th>Amount</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Trx ID</th>
                    <th>Status</th>
					</tr>
              </thead>
              <tbody>
                
				
				<?php

$ddaa = mysql_query("SELECT id, amount, via, too, frm, trx, status FROM add_bal ORDER BY id");
    echo mysql_error();
    while ($data = mysql_fetch_array($ddaa))
    {

if($data[6]=="0"){
$amnt = "

<form action=\"\" method=\"post\">
<button type=\"submit\" name=\"sub\" value=\"1\" class=\"btn btn-success btn-xs\">ADD</button>  &nbsp; &nbsp; &nbsp; &nbsp; 
<button type=\"submit\" name=\"sub\" value=\"9\" class=\"btn btn-danger btn-xs\">Cancel</button>
<input type=\"hidden\" name=\"iidd\" value=\"$data[0]\" >
</form>
";

}else if($data[6]=="1"){
$amnt = "<button class=\"btn btn-success btn-xs\">SUCCESS</button>";	
}else if($data[6]=="9"){
$amnt = "<button class=\"btn btn-danger-alt btn-xs\">Declined</button>";	
}else{
$amnt = "<button class=\"btn btn-info-alt btn-xs\">Unknown</button>";	
}

 echo "                                 <tr>
                                            <td>$data[2]</td>
                                            <td>$data[1]</td>
                                            <td>$data[4]</td>
                                            <td>$data[3]</td>
                                            <td>$data[5]</td>
                                            <td>$amnt</td>


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
 <script>
 	  // Spinner
  var spinner = jQuery('#spinner').spinner();
  spinner.spinner('value', 0);
  </script>


</body>
</html>



