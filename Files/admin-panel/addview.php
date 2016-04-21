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
      <h2><i class="fa fa-dollar"></i> Advertisement List</h2>
    </div>

    
    <div class="contentpanel">
	 <div class="panel panel-default">

        <div class="panel-body">
		
		 <div class="clearfix mb30"></div>

          <div class="table-responsive">
          <table class="table table-striped" id="table2">
              <thead>
                 <tr>
                    <th>#</th>
                    <th>URL</th>
                    <th>Image</th>
                    <th>ACTION</th>

					</tr>
              </thead>
              <tbody>
                
				
				<?php

$ddaa = mysql_query("SELECT id, title, img FROM ads ORDER BY id");
    echo mysql_error();
    while ($data = mysql_fetch_array($ddaa))
    {									
 echo "                                 <tr>
                                            <td>$data[0]</td>
                                            <td>$data[1]</td>
                                            <td><img src=\"../img/advertise/$data[2]\" alt=\"IMG\"  height=\"40\" width=\"100\"></td>
                                            <td>
							<a href=\"addedit.php?id=$data[0]\"  class=\"btn btn-info btn-xs\">Edit</a>
											</td>
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



