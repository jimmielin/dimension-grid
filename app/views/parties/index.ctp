<h2><?php __("Join a Party!"); ?></h2>
<p><?php __("Want to join the politics in the Grid? Looking for a place to share your political views? You definitely want to join the Political side."); ?></p>
<p><?php __("It's not boring like the real-life politics; or, atleast, it won't be boring if you join!"); ?></p>
<br />
<p><?php __("This is a list of the political parties in your current country. Choose one and participate in the fun!"); ?></p>
<?php
	foreach($data as $X) {
		?>
			<div class='profile_special_intro'>
				<span>
					<?php echo $html->link($X["Party"]["name"], "/parties/view/".$X["Party"]["id"]); ?> (<?php __("Created on:"); echo " ".$X["Party"]["found_date"]; ?>)
				</span>
				<p class='textblock'><?php echo $decoda->parse($X["Party"]["party_desc"]); ?></p><br />
				<?php echo $html->link(__("Join this party!", true), "/parties/join/".$X["Party"]["id"]."/".$csrf_token, array("class" => "button navy medium")); ?>
			</div>
		<?php	
	}
?>
<br />
<?php echo $paginator->prev('Previous', array("class" => "button green small"), null, array('class' => 'hidden')); ?>
<?php echo $paginator->numbers(); ?>
<?php echo $paginator->next('Next', array("class" => "button green small"), null, array('class' => 'hidden')); ?>
<?php echo $paginator->counter(); ?>
<br /><br /><hr />
<h2><?php __("They don't match your ideas?"); ?></h2>
<p><?php __("You think that you have an unique political vision? You think you're able to lead a new party? Then create your own."); ?></p>
<p><?php __("Note that Party Leaders are elected every month. If you want to improve an existing party, you can do it! Just join the party and organize people to vote for you, to make your change. It's up to you!"); ?></p>
<?php echo $html->link(__("Made up your mind? Create your own party.", true), "/parties/create", array("class" => "button navy large")); ?>