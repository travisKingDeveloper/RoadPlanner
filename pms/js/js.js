
     $(document).ready(function() { 
	 	//check all box
	 	$('#chkall').click(function(){
			if($('#chkall').attr('checked')){
				$('.checkbox').attr('checked','checked')
			}else {
				$('.checkbox').removeAttr('checked')
			}
		});		
		//delete action
		$('#pmform').submit(function(){
			return confirm('Are you sure to delete?');
		});
		
     });
