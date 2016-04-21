<?php
include ('include/header.php');
?>

  
  <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" />
 
  <link rel="stylesheet" href="css/bootstrap-wysihtml5.css" />
</head>
<body>   
 <?php
include ('include/sidebar.php');
?>

    <div class="pageheader">
      <h2><i class="fa fa-th-list"></i> Add New Bid Game</h2>
    </div>

    
    <div class="contentpanel">
      <div class="panel panel-default">

        <div class="panel-body">
		
		   
<?php





if($_POST)
{

$title = $_POST["title"];
$btext = $_POST["btext"];
$o1 = $_POST["o1"];
$o2 = $_POST["o2"];

////////////////////-------------------->> TITLE ki faka??

 if(trim($title)=="")
      {
$err1=1;
}
 if(trim($o1)=="")
      {
$err2=1;
}

 if(trim($o2)=="")
      {
$err3=1;
}


$error = $err1+$err2+$err3;


if ($error == 0){
	
$res = mysql_query("INSERT INTO bid_game SET title='".$title."', btext='".$btext."', op1='".$o1."', op2='".$o2."'");

if($res){
	echo "<div class=\"alert alert-success alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

NEW MENU Added Successfully!

</div>";
}else{
	echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
}
} else {
	
if ($err1 == 1){
echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Title Can Not be Empty!!!

</div>";
}		
if ($err2 == 1){
echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Option 1 Can Not be Empty!!!

</div>";
}		
if ($err3 == 1){
echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Option 2 Can Not be Empty!!!

</div>";
}		

}




}

?>	
		
		
		
		<form action="" method="post">
				
            <div class="form-group">
              <label class="col-sm-2 control-label">GAME TITLE</label>
              <div class="col-sm-8"><input name="title" value="" class="form-control" type="text"></div>
            </div>
				
            <div class="form-group">
			<label class="col-sm-2 control-label  text-right">Option 1</label>
              <div class="col-sm-4"><input name="o1" value="" class="form-control" type="text"></div>
			  <label class="col-sm-2 control-label  text-right">Option 2</label>
              <div class="col-sm-4"><input name="o2" value="" class="form-control" type="text"></div>
            </div>
			  
		
		
          <textarea id="khan" placeholder="Enter text here..." class="form-control" rows="10" name="btext"></textarea>
		  
		  
				<div class="col-sm-6 col-sm-offset-3"><br/><br/><br/>
				  <button class="btn btn-primary btn-block">Submit</button>
				</div>
			
			 
			 
          </form>
          
		  
		  
        </div>
      </div>
                  
      

      
    </div><!-- contentpanel -->
    
  </div><!-- mainpanel -->

  
</section>


<?php
 include ('include/footer.php');
 ?>


<script src="js/bootstrap-timepicker.min.js"></script>


<script src="js/wysihtml5-0.3.0.min.js"></script>
<script src="js/bootstrap-wysihtml5.js"></script>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>




</body>
</html>



