<h2><?php __("Change Password"); ?></h2>
<p><?php __("It's a good habit to change your password frequently in order to prevent people that know your password to access your account. Remember to keep passwords strong, but don't make it overly complicated. If you forget it, you won't be able to log in!"); ?></p>

<?php echo $form->create(); ?>
<table class='registertable' id='userchangepass_override_registertable'>
	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/key.png"); ?> <?php __("Old Password"); ?></span><br />
			<?php __("Enter your current password here, for verification."); ?>
		</td>
		<td class='registertable_value'>
			<input type='password' name='data[User][oldpassword]' value='' />
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/key.png"); ?> <?php __("New Password"); ?></span><br />
			<?php __("This is your new password. Remember to make it strong; must have more than 6 characters."); ?>
		</td>
		<td class='registertable_value'>
			<input type='password' name='data[User][password2]' value='' />
		</td>
	</tr>

	<tr>
		<td colspan='2' class='registertable_buttonrow'>
			<button type='submit' class='button large centerbtn red'>
				<?php __("Change my password!"); ?>
			</button>
		</td>
	</tr>
</table>
</form>

