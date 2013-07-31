<h2><?php __("Write an Article"); ?></h2>
<p><?php __("Write a new article in your newspaper here."); ?></p>

<?php echo $form->create(false, array("url" => "/newspapers/write/".$csrf_token)); ?>
<table class='registertable'>
	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("fugue/ui-text-field.png"); ?> <?php __("Title"); ?></span><br />
			<?php __("This is the article's title. Note that it must be shorter than 120 characters."); ?>
		</td>
		<td class='registertable_value'>
			<input type='text' name='data[Newspaper_article][title]' maxlength='125' />
		</td>
	</tr>

	<tr>
		<td class='registertable_type'>
			<span><?php echo $html->image("fugue/ui-text-field.png"); ?> <?php __("Content"); ?></span><br />
			<?php __("This is the article's main content. Express your opinion in this box!"); ?><br />
			<?php __("HTML is not allowed and will not be parsed. You can use basic BBCode, such as [b], [i], [u], [img] and other tags to style your article."); ?>
		</td>
		<td class='registertable_value'>
			<textarea name='data[Newspaper_article][content]' cols='100%' rows='15'></textarea>
		</td>
	</tr>

	<tr>
		<td colspan='2' class='registertable_buttonrow'>
			<button type='submit' class='button large centerbtn'>
				<?php __("I've finished writing. Publish it!"); ?>
			</button>
		</td>
	</tr>
</table></form>