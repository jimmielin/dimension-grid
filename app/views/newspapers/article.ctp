<?php echo $html->link($html->image("fugue/arrow-180.png")." ".__("Go back to the Newspaper", true), "/newspapers/view/".$Article["Newspaper"]["id"], array("class" => "actionbtn", "escape" => false)); ?>
<br /><br />
<h2><?php echo $Article["Newspaper_article"]["title"]; ?></h2>
<div class='newspaper_article'>
	<div class='newspaper_article_info'>
		<?php echo $html->image("fugue/user.png"); ?> <strong><?php __("Author:"); ?></strong> <?php echo $Article["Newspaper"]["User"]["username"]; ?>
		&middot;

		<?php echo $html->image("fugue/calendar-day.png"); ?> <strong><?php __("Date"); ?></strong> <?php echo $Article["Newspaper_article"]["date"]; ?>
		&middot; <?php echo $html->image("fugue/chart-pie-separate.png"); ?> <strong><?php __("Popularity"); ?></strong>
			<?php if(!($session->read("Newspaper.voted_".$Article["Newspaper_article"]["id"]) == true)) echo $html->link($html->image("fugue/thumb.png"), "/newspapers/vote/".$Article["Newspaper_article"]["id"]."/down/".$csrf_token, array("escape" => false), __("Are you sure you want to vote down this article? Please remember to leave a comment so the author can improve it.", true)); ?>
			<?php echo $Article["Newspaper_article"]["votes"]; ?>
			<?php if(!($session->read("Newspaper.voted_".$Article["Newspaper_article"]["id"]) == true)) echo $html->link($html->image("fugue/thumb-up.png"), "/newspapers/vote/".$Article["Newspaper_article"]["id"]."/up/".$csrf_token, array("escape" => false)); ?>
	</div>
	<p>
		<?php echo $decoda->parse($Article["Newspaper_article"]["content"]); ?>
	</p>
</div>

<div class='sep'></div>
<h3><?php __("Article Comments"); ?></h3>
	<?php
		if(count($comments) == 0) {
			?>
				<p class='info'>
					<?php __("Sorry, there are no comments to display. Why don't you make one first?"); ?>
				</p>
			<?php
		}
		else {
			foreach($comments as $X) {
				?>
					<div class='commentbox'>
						<div class='commentbox_info'>
							<?php echo $html->image("fugue/user.png"); ?>
							<strong><?php __("Author:"); ?></strong> <?php echo $X["User"]["username"]; ?>

							&middot;
							<?php echo $html->image("fugue/calendar-day.png"); ?> <strong><?php __("Date"); ?></strong> <?php echo $X["Newspaper_comment"]["date"]; ?>
						</div>
						<div class='commentbox_content'>
							<?php echo $decoda->parse($X["Newspaper_comment"]["content"]); ?>
						</div>
					</div>
				<?php
			}
		}
	?>
<?php echo $paginator->prev('Previous', array("class" => "button green small"), null, array('class' => 'hidden')); ?>
<?php echo $paginator->numbers(); ?>
<?php echo $paginator->next('Next', array("class" => "button green small"), null, array('class' => 'hidden')); ?>
<?php echo $paginator->counter(); ?>

<div class='sep'></div>
<h3><?php __("Make a comment!"); ?></h3>
<?php echo $form->create("Newspaper_comment"); ?>
	<?php echo $form->create(false, array("url" => "/newspapers/write/".$csrf_token)); ?>
		<table class='registertable'>
			<tr>
				<td class='registertable_type'>
					<span><?php echo $html->image("fugue/ui-text-field.png"); ?> <?php __("Content"); ?></span><br />
					<?php __("This is the comment's main content. Express your opinion in this box!"); ?><br />
					<?php __("HTML is not allowed and will not be parsed. You can use basic BBCode, such as [b], [i], [u], [img] and other tags to style this comment."); ?>
				</td>
				<td class='registertable_value'>
					<textarea name='data[Newspaper_comment][content]' cols='100%' rows='7'></textarea>
				</td>
			</tr>

			<tr>
				<td colspan='2' class='registertable_buttonrow'>
					<button type='submit' class='button small centerbtn'>
						<?php __("Comment on this article!"); ?>
					</button>
				</td>
			</tr>
		</table>
</form>
