<h2><?php __("Create your Newspaper"); ?></h2>
<p><?php __("You don't have to be a talented writer to write awesome articles in the Grid. If you have an opinion, or something to tell others about, you can always use your newspaper and spread it around. Creating a newspaper is easy, just type in some details and you will be ready to go!"); ?></p>

<?php echo $form->create(false, array("url" => "/newspapers/create/".$csrf_token)); ?>
<table class='registertable'>
	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("fugue/ui-text-field.png"); ?> <?php __("Newspaper Name"); ?></span><br />
			<?php __("How will you call your newspaper? Make it creative. Note that it must be shorter than 120 characters. This can be changed later."); ?>
		</td>
		<td class='registertable_value'>
			<input type='text' name='data[Newspaper][name]' maxlength='125' />
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("silk/coins.png"); ?> <?php __("Cost"); ?></span><br />
			<?php __("Creating a Newspaper will cost you some Platinum. This is a small amount."); ?>
		</td>
		<td class='registertable_value'>
			<?php echo $html->image("silk/platinum.png"); ?> 2.0 PLT
		</td>
	</tr>

	<tr>
		<td colspan='2' class='registertable_buttonrow'>
			<button type='submit' class='button large centerbtn'>
				<?php __("Create my newspaper!"); ?>
			</button>
		</td>
	</tr>
</table></form>