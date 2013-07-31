<h2><?php __("Community Forums"); ?></h2>
<p><?php __("The Community Forums is an extension to the Grid. In there, you can socialize with other players of the Grid easily."); ?></p>
<p><?php __("Note that the Forums and the Grid are different systems, and we cannot transfer your Grid account to the Forum automatically. Please enter a password you want to use for the Grid Forums (it can be different) below, and you will be automatically transferred to the forum."); ?></p>
<p><strong><?php __("Note that this screen will not appear after you have an account in the forums. Your forum account will use the same username as your Grid account, and the password you will define below. You must log in manually to the forums. Logging into the Grid won't log you into the Forums, vice-versa. Sorry for the incovenience!"); ?></strong></p>

<?php echo $form->create("User", array("url" => "/users/forums/".$csrf_token)); ?>
<table class='registertable'>
	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("fugue/key.png"); ?> <?php __("Password"); ?></span><br />
			<?php __("Make it strong; must be longer than 6 characters. This can be different from your Grid Account's Password."); ?>
		</td>
		<td class='registertable_value'>
			<input type='password' name='data[forum_pass]' />
		</td>
	</tr>

	<tr>
		<td colspan='2' class='registertable_buttonrow'>
			<button type='submit' class='button large centerbtn'>
				<?php __("Join the Grid Community Forums!"); ?>
			</button>
		</td>
	</tr>
</table>
</form>