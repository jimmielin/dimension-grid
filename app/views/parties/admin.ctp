<h2><?php __("Party Administration:"); echo " ".$data["Party"]["name"]; ?></h2>
<?php
	switch($action) {
		case "index":
			?>
				<p><?php __("From here, you can see an overview of your party. Most things can be seen by your party members; this page is provided just for convenience."); ?></p>
				<br />
				<h3><?php __("Basic Information Overview"); ?></h3>
					<table class='data_table party_leader_overview_table'>
						<tr>
							<td><?php __("Belonging Country"); ?></td>
							<td>
								<?php echo $html->image("flags/".$data["Country"]["short_name"].".png", array("class" => "country_flag_mini")); ?>
								<?php echo $html->link($data["Country"]["long_name"], "/countries/view/".$data["Country"]["id"]); ?>
							</td>
						</tr>
						<tr>
							<td><?php __("Party Members"); ?></td>
							<td>
								<?php echo count($data["Member"]); ?>
							</td>
						</tr>
						<tr>
							<td><?php __("Party Founder"); ?></td>
							<td><?php echo $html->link($data["Founder"]["username"], "/users/view/".$data["Founder"]["id"]); ?></td>
						</tr>
						<tr>
							<td><?php __("Party Founding Date"); ?></td>
							<td><?php echo $data["Party"]["found_date"]; ?></td>
						</tr>
					</table>
				<br />
				<h3><?php __("Party Description"); ?></h3>
					<p class='textblock'><?php echo $decoda->parse($data["Party"]["party_desc"]); ?></p>
					<?php echo $html->link(__("Edit Description", true), "/parties/admin/".$ID."/editdesc", array("class" => "button green medium")); ?>
			<?php
		break;

		case 'editdesc':
			?>
				<p><?php __("From here, you can edit your party's description. Note that this description can be viewed by anyone, including non-party members."); ?></p>
				<br />
				<h3><?php __("Current Party Description"); ?></h3>
					<p class='textblock'><?php echo $decoda->parse($data["Party"]["party_desc"]); ?></p>
				<br />
				<h3><?php __("Type your new Party Description here"); ?></h3>
					<?php echo $form->create("Party", array("url" => "/parties/admin/".$ID."/editdesc")); ?>
					<p><?php __("Enter your new party description in the textarea below. Use BBCode for formatting; HTML is NOT allowed."); ?></p>
					<?php echo $form->input("party_desc", array("label" => false, "div" => false, "rows" => "6", "cols" => "85%", "default" => $data["Party"]["party_desc"])); ?>
					<br />
					<button type='submit' class='button green medium'><?php __("Edit Description"); ?></button>
					<?php echo $form->end(); ?>
			<?php
		break;

	}
?>