<h2><?php __("Join the Grid!"); ?></h2>
<p><?php __("Want to experience a totally different world? Or better, you want to try the Grid for yourself? Great! Enter some details and you're ready to go!"); ?></p>
<p class='notice'><?php __("Note that a person may only have one account. If you create multiple accounts, you will be banned in the Grid."); ?></p>

<?php echo $form->create("User"); ?>
<table class='registertable'>
	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/user.png"); ?> <?php __("Username"); ?></span><br />
			<?php __("This is your name in the Grid. Note that you cannot change this later. Choose wisely, and keep it short!"); ?>
		</td>
		<td class='registertable_value'>
			<?php echo $form->input("username", array("label" => false, "div" => false, "default" => (isset($s_username) ? $s_username : ""))); ?>
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/key.png"); ?> <?php __("Password"); ?></span><br />
			<?php __("Make your password strong; must have more than 6 characters."); ?>
		</td>
		<td class='registertable_value'>
			<input type='password' name='data[User][password2]' value='' />
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/email.png"); ?> <?php __("Email Address"); ?></span><br />
			<?php __("We won't spam it - promise!"); ?>
		</td>
		<td class='registertable_value'>
			<?php echo $form->input("email", array("label" => false, "div" => false, "default" => (isset($s_email) ? $s_email : ""))); ?>
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/world.png"); ?> <?php __("Location"); ?></span><br />
			<?php __("Where would you like to live in the Grid? It doesn't have to be your real location."); ?>
			
			Note that not all countries exist in the Grid yet. More countries and regions will be added as the players increase.
		</td>
		<td class='registertable_value'>
			<select name="data[User][region_id]" id="region_id">
				<?php
				foreach($regionsList as $X) {
					echo "<optgroup label='".$X["Country"]["long_name"]."'>";
						// now their regions..
						foreach($X["Region"] as $Y) {
							// are we occupied?
							if($Y["original_id"] != $Y["owner_id"]) {
								$Occup = " (Occupied)";
							} else $Occup = "";
							
							if(isset($s_region_id) and $s_region_id == $Y["id"]) $Selected = " selected='selected'";
							else $Selected = "";
							
							echo "<option value='".$Y["id"]."'".$Selected.">".$Y["name"].$Occup."</option>";
						}
					echo "</optgroup>";
				}
				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/comments.png"); ?> <?php __("CAPTCHA"); ?></span><br />
			<?php __("Help us keep the Grid bot-free. Please enter the characters shown in the image, so we can make sure that you are a human."); ?><br />
			<strong><?php __("Note that each image has 6 characters, so if you don't see all of them click to get a new one."); ?></strong>
		</td>
		<td class='registertable_value'>
			<a onclick="javascript:document.images.captcha.src='<?php echo $html->url('/users/captcha');?>?' + Math.round(Math.random(0)*1000)+1">
				<img id="captcha" src="<?php echo $html->url('/users/captcha'); ?>?<?php echo rand(0,800); ?>" alt="" />
			</a>
			<br /><br />
			<input type='username' name='data[User][captcha]' value='' />
		</td>
	</tr>

	<tr>
		<td colspan='2' class='registertable_buttonrow'>
			<button type='submit' class='button large centerbtn'>
				<?php __("Done? Join the Grid!"); ?>
			</button>
		</td>
	</tr>
</table>
</form>