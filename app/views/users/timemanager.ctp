<h2><?php __("Time Management"); ?></h2>
<p><?php __("Time in the Grid, just like in real life, is precious. From here, you can view tasks that you should perform every Grid-day and review how you managed your time."); ?></p>

<table class='timetable'>
	<tr>
		<td width='4%' class='timetable_marker timetable_marker_first'>01:00</td>
		<td width='4%' class='timetable_marker'>02:00</td>
		<td width='4%' class='timetable_marker'>03:00</td>
		<td width='4%' class='timetable_marker'>04:00</td>
		<td width='4%' class='timetable_marker'>05:00</td>
		<td width='4%' class='timetable_marker'>06:00</td>
		<td width='4%' class='timetable_marker'>07:00</td>
		<td width='4%' class='timetable_marker'>08:00</td>
		<td width='4%' class='timetable_marker'>09:00</td>
		<td width='4%' class='timetable_marker'>10:00</td>
		<td width='4%' class='timetable_marker'>11:00</td>
		<td width='4%' class='timetable_marker'>12:00</td>
		<td width='4%' class='timetable_marker'>13:00</td>
		<td width='4%' class='timetable_marker'>14:00</td>
		<td width='4%' class='timetable_marker'>15:00</td>
		<td width='4%' class='timetable_marker'>16:00</td>
		<td width='4%' class='timetable_marker'>17:00</td>
		<td width='4%' class='timetable_marker'>18:00</td>
		<td width='4%' class='timetable_marker'>19:00</td>
		<td width='4%' class='timetable_marker'>20:00</td>
		<td width='4%' class='timetable_marker'>21:00</td>
		<td width='4%' class='timetable_marker'>22:00</td>
		<td width='4%' class='timetable_marker'>23:00</td>
		<td width='4%' class='timetable_marker'>24:00</td>
	</tr>
	<tr>
		<?php 
			// has the user worked?
			if($userdata["User"]["task_worked"] > 0) {
				?>
					<td colspan='<?php echo $userdata["User"]["task_worked"]; ?>' class='timetable_action'>
						<div class='timetable_action_div timetable_action_div_work'>
							<?php __("Work"); ?>
						</div>
					</td>
				<?php
			}

			if($userdata["User"]["task_studied"] > 0) {
				?>
					<td colspan='<?php echo $userdata["User"]["task_studied"]; ?>' class='timetable_action'>
						<div class='timetable_action_div timetable_action_div_study'>
							<?php __("Study"); ?>
						</div>
					</td>
				<?php
			}

			if($userdata["User"]["task_trained"] > 0) {
				?>
					<td colspan='<?php echo $userdata["User"]["task_trained"]; ?>' class='timetable_action'>
						<div class='timetable_action_div timetable_action_div_train'>
							<?php __("Train"); ?>
						</div>
					</td>
				<?php
			}

			if(24 - $userdata["User"]["time_spent"] > 0) {
				?>
					<td colspan='<?php echo 24 - $userdata["User"]["time_spent"]; ?>'>
						<div class='timetable_action_div timetable_action_div_idle'>
							&nbsp;
						</div>
					</td>
				<?php
			}
		?>
	</tr>
</table>
<br />
	<?php
		if($userdata["User"]["task_worked"] > 0) {
			$workRes = unserialize($userdata["User"]["work_result_data"]);
			?>
				<div class='timetable_result_div timetable_result_div_work'>
					<span class='timetable_result_div_header'><?php __("Work Results"); ?></span><br />
					<strong><?php echo $html->image("fugue/chart-up-color.png"); ?> <?php __("Productivity"); ?>:</strong> <?php echo $workRes["productivity"]; ?><br />
					<strong><?php echo $html->image("fugue/chart-up.png"); ?> <?php __("Skill Gain"); ?>:</strong> <?php echo $workRes["skillGain"]; ?><br />
					<strong><?php echo $html->image("fugue/money--plus.png"); ?> <?php __("Salary"); ?>:</strong>
						<?php echo $workRes["hours"] * $userdata["User"]["hourly_wage"]; ?>
						<?php
							foreach($userdata["Account"] as $X) {
								if($X["Currency"]["country_id"] == $userdata["Region"]["Country"]["id"]) {
									echo $X["Currency"]["name"];
								}
							}
						?>
					<br />
					<strong><?php echo $html->image("fugue/plus-button.png"); ?> <?php __("Booster"); ?>:</strong> TODO/codename:<?php echo $workRes["booster"]; ?><br />
				</div>
			<?php
		}

		if($userdata["User"]["task_studied"] > 0) {
			$studyRes = unserialize($userdata["User"]["study_result_data"]);
			?>
				<div class='timetable_result_div timetable_result_div_study'>
					<span class='timetable_result_div_header'><?php __("Study Results"); ?></span><br />
					<strong><?php echo $html->image("fugue/chart-up.png"); ?> <?php __("Skill Gain"); ?>:</strong> <?php echo $studyRes["productivity"]; ?><br />
					<strong><?php echo $html->image("fugue/plus-button.png"); ?> <?php __("Booster"); ?>:</strong> TODO/codename:<?php echo $studyRes["booster"]; ?><br />
				</div>
			<?php
		}

		if($userdata["User"]["task_trained"] > 0) {
			$trainRes = unserialize($userdata["User"]["train_result_data"]);
			?>
				<div class='timetable_result_div timetable_result_div_train'>
					<span class='timetable_result_div_header'><?php __("Training Results"); ?></span><br />
					<strong><?php echo $html->image("fugue/chart-up.png"); ?> <?php __("Skill Gain"); ?>:</strong> <?php echo $trainRes["productivity"]; ?><br />
					<strong><?php echo $html->image("fugue/plus-button.png"); ?> <?php __("Booster"); ?>:</strong> TODO/codename:<?php echo $trainRes["booster"]; ?><br />
				</div>
			<?php
		}
	?>
<br />
<h3><?php __("Tasks"); ?></h3>
<table width='100%'>
	<tr>
		<td><?php echo $html->link($html->image("fugue/paper-clip.png")." ".__("Work @ Office", true), "/companies", array("escape" => false, "class" => "actionbtn")); ?></td>
		<td><?php echo $html->link($html->image("fugue/books.png")." ".__("Study @ Library", true), "/users/library", array("escape" => false, "class" => "actionbtn")); ?></td>
		<td><?php echo $html->link($html->image("fugue/bomb.png")." ".__("Train @ Field", true), "/users/training", array("escape" => false, "class" => "actionbtn")); ?></td>
	</tr>
</table>
