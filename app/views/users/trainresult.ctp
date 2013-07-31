<?php $trainRes = unserialize($userdata["User"]["train_result_data"]); ?>
<h2><?php __("Training Results"); ?></h2>
<p><?php __("Congratulations! Your skill went up really quickly. See below!"); ?></p>

<div class='work_result_title'>
	<span><?php __("Military Skill Gain"); ?></span><br />
	<span class='work_result_value'><?php echo $trainRes["productivity"]; ?></span>
</div>

<div class='work_result_div'>
	<strong><?php echo $html->image("fugue/chart-up.png"); ?> <?php __("Skill Gain"); ?>:</strong> <?php echo $trainRes["productivity"]; ?><br />
	<strong><?php echo $html->image("fugue/clock.png"); ?> <?php __("Trained for"); ?>:</strong> <?php echo $trainRes["hours"]; ?> <?php __("hours"); ?><br />
	<strong><?php echo $html->image("fugue/plus-button.png"); ?> <?php __("Booster"); ?>:</strong> TODO/codename:<?php echo $trainRes["booster"]; ?><br />
</div>

<br />
<?php echo $html->link($html->image("fugue/clock.png")." ".__("Click here to go back to the time management page", true), "/users/timemanager", array("escape" => false, "class" => "actionbtn")); ?>
<br />
<h3><?php __("Tasks"); ?></h3>
<table width='100%'>
	<tr>
		<td><?php echo $html->link($html->image("fugue/paper-clip.png")." ".__("Work @ Office", true), "/companies", array("escape" => false, "class" => "actionbtn")); ?></td>
		<td><?php echo $html->link($html->image("fugue/books.png")." ".__("Study @ Library", true), "/users/library", array("escape" => false, "class" => "actionbtn")); ?></td>
		<td><?php echo $html->link($html->image("fugue/bomb.png")." ".__("Train @ Field", true), "/users/training", array("escape" => false, "class" => "actionbtn")); ?></td>
	</tr>
</table>