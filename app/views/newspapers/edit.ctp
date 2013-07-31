<h2><?php __("Edit your Newspaper"); ?></h2>
<p><?php __("You can change some information about your newspaper here. Currently you can only change the name, but there will be more things to do later."); ?></p>

<?php echo $form->create(false, array("url" => "/newspapers/edit/".$csrf_token)); ?>
<table class='registertable'>
	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("fugue/ui-text-field.png"); ?> <?php __("Newspaper Name"); ?></span><br />
			<?php __("How will you call your newspaper? Make it creative. Note that it must be shorter than 120 characters."); ?>
		</td>
		<td class='registertable_value'>
			<input type='text' name='data[Newspaper][name]' maxlength='125' />
		</td>
	</tr>
	
	<tr>
		<td colspan='2' class='registertable_buttonrow'>
			<button type='submit' class='button large centerbtn green'>
				<?php __("Edit my newspaper!"); ?>
			</button>
		</td>
	</tr>
</table></form>