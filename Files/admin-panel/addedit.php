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
      <h2><i class="fa fa-dollar"></i> EDIT Advertisement</h2>
    </div>

    
    <div class="contentpanel">
      <div class="panel panel-default">

        <div class="panel-body">
		
		   
<?php

$eid = $_GET["id"];

if($_POST)
{

$title = $_POST["title"];
$btext = $_POST["btext"];



// IMAGE UPLOAD //////////////////////////////////////////////////////////
	$folder = "../img/advertise/";
	$extention = strrchr($_FILES['bgimg']['name'], ".");
	if ($extention == ".jpg" || $extention == ".JPG" || $extention == ".png" || $extention == ".PNG" || $extention == ".jpeg" || $extention == ".JPEG" || $extention == ".gif" || $extention == ".GIF"){
	$new_name = time();
	$bgimg = $new_name.$extention;
	$uploaddir = $folder . $bgimg;
	move_uploaded_file($_FILES['bgimg']['tmp_name'], $uploaddir);
	}
	
	else {
			echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

Only JPG, PNG and GIF Supported. $extention is not supported. 

</div>";
		
	}
//////////////////////////////////////////////////////////////////////////


////////////////////-------------------->> TITLE ki faka??

 if(trim($title)=="")
      {
$err1=1;
}


$error = $err1;


if ($error == 0){
	//$rjphoto = $new_name.'.jpg';
	
$res = mysql_query("UPDATE ads SET title='".$title."', img='".$bgimg."' WHERE id='".$eid."'");

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
} else {
	
if ($err1 == 1){
echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>	

URL Can Not be Empty!!!

</div>";
}		

}
}




$old = mysql_fetch_array(mysql_query("SELECT title FROM ads WHERE id='".$eid."'"));
?>	
		
		
		
				
		<form name="" id="" action="" method="post" enctype="multipart/form-data" >
            <div class="form-group">
              <label class="col-sm-3 control-label">Advertisement URL</label>
              <div class="col-sm-6"><input name="title" value="<?php echo $old[0]; ?>" class="form-control" type="text"></div>
            </div>
			
			
			            <div class="form-group">
              <label class="col-sm-3 control-label">IMAGE</label>
              <div class="col-sm-6"><input name="bgimg" type="file" id="bgimg" /></div>
            </div>
			  
	  
				<div class="col-sm-6 col-sm-offset-3"><br/>
				  <button class="btn btn-primary btn-block">Submit</button>
				</div>
          </form>

        </div>
      </div>
                  
    </div><!-- contentpanel -->
  </div><!-- mainpanel -->



<?php
 include ('include/footer.php');
 ?>


<script src="js/bootstrap-timepicker.min.js"></script>


<script src="js/wysihtml5-0.3.0.min.js"></script>
<script src="js/bootstrap-wysihtml5.js"></script>
<script src="js/ckeditor/ckeditor.js"></script>
<script src="js/ckeditor/adapters/jquery.js"></script>



<script>
jQuery(document).ready(function(){
    
    "use strict";
    
  // HTML5 WYSIWYG Editor
  jQuery('#wysiwyg').wysihtml5({color: true,html:true});
  
  // CKEditor
  jQuery('#ckeditor').ckeditor();
  
  jQuery('#inlineedit1, #inlineedit2').ckeditor();
  
  // Uncomment the following code to test the "Timeout Loading Method".
  // CKEDITOR.loadFullCoreTimeout = 5;

  window.onload = function() {
  // Listen to the double click event.
  if ( window.addEventListener )
	document.body.addEventListener( 'dblclick', onDoubleClick, false );
  else if ( window.attachEvent )
	document.body.attachEvent( 'ondblclick', onDoubleClick );
  };

  function onDoubleClick( ev ) {
	// Get the element which fired the event. This is not necessarily the
	// element to which the event has been attached.
	var element = ev.target || ev.srcElement;

	// Find out the div that holds this element.
	var name;

	do {
		element = element.parentNode;
	}
	while ( element && ( name = element.nodeName.toLowerCase() ) &&
		( name != 'div' || element.className.indexOf( 'editable' ) == -1 ) && name != 'body' );

	if ( name == 'div' && element.className.indexOf( 'editable' ) != -1 )
		replaceDiv( element );
	}

	var editor;

	function replaceDiv( div ) {
		if ( editor )
			editor.destroy();
		editor = CKEDITOR.replace( div );
	}

	 jQuery('#timepicker').timepicker({defaultTIme: false});
  jQuery('#timepicker2').timepicker({showMeridian: false});
  jQuery('#timepicker3').timepicker({minuteStep: 15});

	
	
});



</script>
</body>
</html>



