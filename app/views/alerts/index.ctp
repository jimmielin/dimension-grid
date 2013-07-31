<h3><?php __("Viewing Alerts"); ?></h3>
<p><?php __("These are your alerts. Alerts are short messages which alert you (obviously) of events that happened in the Grid which are related to you."); ?></p>
<p><?php __("Remember to delete your alerts after viewing them, in order to keep this page clean."); ?></p>
<div class='info'>
	<?php __("Note that alerts are marked as read automatically, but are not deleted. Please remember to delete the alerts that you do not need anymore!"); ?>
</div>
<?php
	foreach($data as $X) {
		?>
		<div class="alertbox<?php echo ($X["Alert"]["read"] == "0" ? " newalert" : ""); ?>">
			<?php echo $html->image("silk/date.png"); echo $X["Alert"]["date"]; ?>
			<?php echo $html->link(__("Delete Alert", true), "/alerts/delete/".$X["Alert"]["id"], array("class" => "button orange small")); ?>
			<p>
				<?php echo $decoda->parse($X["Alert"]["message"]); ?>
			</p>
		</div>
		<?php
	}

	if(count($data) > 0) {
		echo $html->link(__("Delete All", true), "/alerts/deleteall", array("class" => "button red medium"));
	}
	else {
		echo "<p class='message'><em>".__("You have no alerts. Get more involved in the Grid!", true)."</em></p>";
	}
?>