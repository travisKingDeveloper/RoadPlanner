<div class="itemtitle s_clear">
<h1>Messages</h1>
</div>

<div class="itemtitle newpm_notice s_clear">
<span class="right">
</span>
<a href="index.php?<?php echo isset($_SESSION['PMS_PAGE'])?$_SESSION['PMS_PAGE']:''; ?>" class="back">Back</a>
<span class="left">Messages with <strong><?php echo $with[0]['User'][INT_USER_USR];?></strong></span>
</div>

<div id="pmlist">

<ul class="pm_list">	
	<li class="s_clear <?php echo $msg[0]['Message']['sender_id']==$_SESSION[INT_ACCESS_SESSION]?'self':'';?>" >
		<a name="pm_2091059"></a>		
			<a class="avatar" src="#">
			<img src="img/avatar.gif">
			</a>
		<p class="cite">
		<cite><?php echo $msg[0]['User'][INT_USER_USR];?></cite>
		<?php echo $msg[0]['Message']['date'];?></p>
		<div class="summary">
			<?php echo $msg[0]['Message']['content'];?>
		</div>		
	</li>	
</ul>

<div id="pm_list">
	<ul id="pm_new" class="pm_list" style="display: none;"></ul>
</div>



</div>