<?php $resRes = unserialize($userdata["User"]["work_result_data"]); ?>
<h2><?php __("Work Results"); ?></h2>
<p><?php __("You have finished working. This is the detailed information of your work results."); ?></p>

<div class='work_result_title'>
	<span><?php __("Productivity (Units Produced)"); ?></span><br />
	<span class='work_result_value'><?php echo $resRes["productivity"]; ?></span>
</div>

<div class='work_result_div'>
	<strong><?php echo $html->image("fugue/chart-up.png"); ?> <?php __("Skill Gain"); ?>:</strong> <?php echo $resRes["skillGain"]; ?><br />
	<strong><?php echo $html->image("fugue/money--plus.png"); ?> <?php __("Salary"); ?>:</strong>
		<?php echo $resRes["hours"] * $userdata["User"]["hourly_wage"]; ?>
		<?php
			foreach($userdata["Account"] as $X) {
				if($X["Currency"]["country_id"] == $userdata["Region"]["Country"]["id"]) {
					echo $X["Currency"]["name"];
				}
			}
		?>
	<br />
	<strong><?php echo $html->image("fugue/plus-button.png"); ?> <?php __("Booster"); ?>:</strong> TODO/codename:<?php echo $resRes["booster"]; ?><br />
	
</div>

<br />
<?php echo $html->link($html->image("fugue/clock.png")." ".__("Click here to go back to the time management page", true), "/users/timemanager", array("escape" => false, "class" => "actionbtn")); ?><br />
<?php echo $html->link($html->image("fugue/paper-clip.png")." ".__("Go back to your company", true), "/companies", array("escape" => false, "class" => "actionbtn")); ?>
<br />
<h3><?php __("Tasks"); ?></h3>
<table width='100%'>
	<tr>
		<td><?php echo $html->link($html->image("fugue/paper-clip.png")." ".__("Work @ Office", true), "/companies", array("escape" => false, "class" => "actionbtn")); ?></td>
		<td><?php echo $html->link($html->image("fugue/books.png")." ".__("Study @ Library", true), "/users/library", array("escape" => false, "class" => "actionbtn")); ?></td>
		<td><?php echo $html->link($html->image("fugue/bomb.png")." ".__("Train @ Field", true), "/users/training", array("escape" => false, "class" => "actionbtn")); ?></td>
	</tr>
</table>