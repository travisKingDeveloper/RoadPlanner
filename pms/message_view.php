<div class="itemtitle s_clear">
<h1>Messages</h1>
</div>

<div class="itemtitle newpm_notice s_clear">
<span class="right">
total <?php echo sizeof($msgs);?>
</span>
<a href="index.php?<?php echo isset($_SESSION['PMS_PAGE'])?$_SESSION['PMS_PAGE']:''; ?>" class="back">Back</a>
<span class="left">Messages with <strong><?php echo $with[0]['User'][INT_USER_USR];?></strong></span>
</div>

<div id="pmlist">

<ul class="pm_list">
	<?php
		foreach($msgs as $msg){
	?>	
	<li class="s_clear <?php echo $msg['Message']['sender_id']==$_SESSION[INT_ACCESS_SESSION]?'self':'';?>" >
		<a name="pm_2091059"></a>		
			<a class="avatar" src="#">
			<img src="img/avatar.gif">
			</a>
		<p class="cite">
		<cite><?php echo $msg['User'][INT_USER_USR];?></cite>
		<?php echo $msg['Message']['date'];?></p>
		<div class="summary">
			<?php echo $msg['Message']['content'];?>
		</div>		
	</li>
	<?php } ?>
</ul>

<div id="pm_list">
	<ul id="pm_new" class="pm_list" style="display: none;"></ul>
</div>

<form method="post" action="index.php?reply" class="pmreply">
	<input name="id" type="hidden" value="<?php echo $hiddenView;?>"></input>
	<input name="receiver_id" type="hidden" value="<?php echo $with[0]['User'][INT_USER_ID];?>"></input>
	<textarea id="pmreplymessage" name="message" class="txtarea" cols="30" rows="5" style="border-top: medium none; margin-top: -1px;">
	</textarea>
	<p style="margin: 5px 0pt;">
		<input type="submit" value="Reply"></input>
	</p>
</form>

</div>