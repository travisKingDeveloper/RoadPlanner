<div class="itemtitle s_clear">
<h1>Send a message</h1>
</div>

<div class="itemtitle newpm_notice s_clear">
	<a href="index.php" class="back">Back</a>
</div>

<div id="pmlist">
	<div id="pm_list">
		<ul id="pm_new" class="pm_list" style="display: none;"></ul>
	</div>
	
	<form method="post" action="index.php?send" class="pmreply">
		<input type="hidden" name="post" value="1"/>
		<label for"receiver_id">Receiver: </label>
			<select name="receiver_id">
				<?php
					foreach($users as $usr){
						if($usr['User'][INT_USER_ID]!=$_SESSION[INT_ACCESS_SESSION]){
				?>
					   		<option value="<?php echo $usr['User'][INT_USER_ID];?>"><?php echo $usr['User'][INT_USER_USR];?></option>
				<?php
						}
					}
				?>			
			</select>
			
		<div  style="height:10px"></div>
		
		<textarea id="pmreplymessage" name="message" class="txtarea" cols="30" rows="5" style="border-top: medium none; margin-top: -1px;">
		</textarea>
		<p style="margin: 5px 0pt;">
			<input type="submit" value="Send"></input>
		</p>
	</form>

</div>