<div class="itemtitle s_clear">
<h1>Messages</h1>
</div>

<div class="pm_header colplural itemtitle s_clear">
<a href="index.php?send" class="postpm">+ Send a message</a>
<ul>
<li><a href="index.php?index" hidefocus="true"><span>All</span></a></li>
<li class="current"><a href="index.php?index_sent" ><span>Sent</span></a></li>
<li><a href="index.php?index_received"><span>Received</span></a></li>
</ul>
</div>

<form method="post" id="pmform" action="index.php?delete">
	<input name="readopt" value="0" type="hidden">
    <ul class="pm_list">
    	<?php  
    	if(isset($msgs)){  		
    		foreach($msgs as $msg){
    	?>
        <li id="pm_2076634" class="s_clear ">
        <a href="index.php?view&id=<?php echo $msg['Message']['id']; ?>" class="avatar">
               	<img src="img/avatar.gif">
        </a>
        <p class="cite">
        	<cite>
        		<a href="index.php?view&id=<?php echo $msg['Message']['id']; ?>">
	        		<?php 
	        		echo $msg['User'][INT_USER_USR];
	        		?>
	        	</a>
        	</cite>
        		<?php 
        		echo $msg['Message']['date'];
        		?>
        </p>
        
        <div class="summary">
        	<?php 
        		echo $msg['Message']['content'];
        	?>
        </div>
        
        <p class="more"><a href="index.php?read&id=<?php echo $msg['Message']['id']; ?>" class="to">Read Message</a></p>
        <span class="action">
        	<input name="mid[]" class="checkbox" value="<?php echo $msg['Message']['id']; ?>" type="checkbox">
        </span>
        </li>
    	
    	<?php
    		}
    	}
    	?>        
    </ul>

    <div class="s_clear" style="margin: 10px 0pt;">
    <span class="right">
    <input class="checkbox" id="chkall" name="chkall" type="checkbox"><label for="chkall">Select All</label>						
    	<span class="pipe">|</span>
    	<input type="submit" value="Delete"/>
    </span>
    Total <?php echo $numrows;?> messages
    </div>
    <div>
        <div class="pages">
        	<?php
        		$nav  = '';
				for($page = 1; $page <= $maxPage; $page++) {
				   if ($page == $pageNum)
				   {
				      $nav .= "<strong>$page</strong>"; // no need to create a link to current page
				   }
				   else
				   {
				      $nav .= " <a href=\"$self&page=$page\">$page</a> ";
				   }
				}
        		if ($pageNum > 1){
					   $page  = $pageNum - 1;
					   $prev  = " <a href=\"$self&page=$page\"  class=\"prev\">Prev</a> ";
					
					   $first = " <a href=\"$self&page=1\" class=\"prev\">First</a> ";
				}else {
					   $prev  = '&nbsp;'; // we're on page one, don't print previous link
					   $first = '&nbsp;'; // nor the first page link
				}
					
				if ($pageNum < $maxPage){
				   $page = $pageNum + 1;
				   $next = " <a href=\"$self&page=$page\" class=\"next\">Next</a> ";
				
				   $last = " <a href=\"$self&page=$maxPage\" class=\"next\">Last Page</a> ";
				}else{
				   $next = '&nbsp;'; // we're on the last page, don't print next link
				   $last = '&nbsp;'; // nor the last page link
				}
				
				
				echo  $prev . $nav . $next  ;
        	?>        	
        </div>
    </div>
</form>