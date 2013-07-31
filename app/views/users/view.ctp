<h2><?php echo $data["User"]["username"]; ?></h2>
<table class='layout_table user_layout_table'>
	<tr>
		<td class='layout_table_left'>
			<!-- todo: show user avatar here -->
			<table class='sidebar_table_special'>
				<tr>
					<td class='sidebar_table_special_top' colspan='2'>
						<?php echo $data["User"]["username"]; ?>
					</td>
				</tr>
				<tr>
					<td class='sidebar_table_special_type'><?php __("Citizenship"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php 
							echo $html->image("flags/".$data["Citizenship"]["short_name"].".png", array("class" => "country_flag_mini"))." ";
							echo $html->link($data["Citizenship"]["long_name"], "/countries/view/".$data["Citizenship"]["id"]);
						?>
					</td>
				</tr>
				<tr>
					<td class='sidebar_table_special_type'><?php __("Location"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							echo $html->image("flags/".$data["Region"]["Country"]["short_name"].".png", array("class" => "country_flag_mini"))." ";
							echo $html->link($data["Region"]["name"], "/regions/view/".$data["Region"]["id"]);
							echo ", ";
							echo $html->link($data["Region"]["Country"]["long_name"], "/countries/view/".$data["Region"]["Country"]["id"]);
						?>
					</td>
				</tr>
				<tr>
					<td class='sidebar_table_special_topsub' colspan='2'>
						<?php __("Political Status"); ?>
					</td>
				</tr>
				<tr>
					<td class='sidebar_table_special_type'><?php __("Role"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							// check from the highest level to the lowest one.
							// make sure he's in his native country. if not, output 'Immigrant'
							if($data["Citizenship"]["id"] != $data["Region"]["owner_id"]) __("Immigrant");
							else {
								if($data["Citizenship"]["president_id"] == $data["User"]["id"]) __("President");
								elseif($data["User"]["congress_id"] != "0") __("Congressman");
								elseif($data["User"]["party_id"] != "0" and $data["Party"]["leader_id"] == $data["User"]["id"]) __("Party Leader");
								elseif($data["User"]["party_id"] != "0") __("Party Member");
								else __("Citizen");
							}
						?>
					</td>
				</tr>
			</table>
			<?php
				if($ID == $userdata["User"]["id"]) {
					echo "<br />";
					echo $html->link($html->image("fugue/key--pencil.png")." ".__("Change Password", true), "/users/changepass", array("escape" => false, "class" => "actionbtn"));
				}
			?>
		</td>

		<td class='layout_table_content'>
			<table class='profile_overview_table'>
				<tr>
					<td width="34px">
						<?php echo $html->image("fugue-32/plus.png"); ?>
					</td>
					<td width="70px" class='sepr'>
						<strong><?php __("Health"); ?></strong>
						<span><?php echo $data["User"]["health"]; ?>%</span>
					</td>

					<td width="34px">
						<?php echo $html->image("fugue-32/calendar-day.png"); ?>
					</td>
					<td width="130px" class='sepr'>
						<strong><?php __("Born On"); ?></strong>
						<span><?php echo __("Grid Day ", true).floor(($time->fromString($data["User"]["joined"]) - 1283299200)/60/60/24); ?></span>
					</td>


					<td width="25%">
						&nbsp;
					</td>

					<td>&nbsp;</td>
				</tr>
			</table>
			<br />
			<h3><?php __("Grid Identity"); ?></h3>
			<table class='grid_identity_table'>
				<tr>
					<th width="25%"><?php __("Politics"); ?></th>
					<th width="25%"><?php __("Economy"); ?></th>
					<th width="25%"><?php __("Military"); ?></th>
					<th width='25%'><?php __("Social"); ?></th>
				</tr>
				<tr>
					<td>
						<?php
							// check from the highest level to the lowest one.
							// make sure he's in his native country. if not, output 'Immigrant'
							if($data["Citizenship"]["id"] != $data["Region"]["owner_id"])
								echo "<span class='actionbtn'>".$html->image("flags/".$data["Region"]["Country"]["short_name"].".png", array("class" => "country_flag_mini"))." ".__("Immigrant", true)."</span>";
							else {
								$countryFlag = $html->image("flags/".$data["Citizenship"]["short_name"].".png", array("class" => "country_flag_mini"))." ";
								if($data["Citizenship"]["president_id"] == $data["User"]["id"])
									echo $html->link($countryFlag.__("Country President", true), "/countries/view/".$data["Citizenship"]["id"], array("class" => "actionbtn", "escape" => false));
								if($data["User"]["congress_id"] != "0")
									echo $html->link($countryFlag.__("Congress Member", true), "/countries/view/".$data["Citizenship"]["id"], array("class" => "actionbtn", "escape" => false));
								if($data["User"]["party_id"] != "0" and $data["Party"]["leader_id"] == $data["User"]["id"])
									echo $html->link($countryFlag.__("Party Leader", true)." (<strong>".$data["Party"]["name"]."</strong>)", "/parties/view/".$data["User"]["party_id"], array("class" => "actionbtn", "escape" => false));
								elseif($data["User"]["party_id"] != "0")
									echo $html->link($countryFlag.__("Party Member", true)." (<strong>".$data["Party"]["name"]."</strong>)", "/parties/view/".$data["User"]["party_id"], array("class" => "actionbtn", "escape" => false));
								else {
									if($data["Citizenship"]["president_id"] != $data["User"]["id"] and $data["User"]["congress_id"] == "0")
										echo "<div class='actionbtn'>".$countryFlag." ".__("Citizen", true)."</div>";
								}
							}
						?>
					</td>
					<td>
						<?php
							// is the user employed?
							if($data["User"]["employee_set_id"] != "0") {
								echo $html->link($html->image("fugue/briefcase.png")." ".__("Employee:", true)." ".$data["Employee_set"]["Company"]["name"], "/companies/view/".$data["Employee_set"]["Company"]["id"], array("class" => "actionbtn", "escape" => false));

								$employed = 1;
							}

							if(count($data["Owned_company"]) > 0) {
								$employed = 1;

								foreach($data["Owned_company"] as $X) {
									echo $html->link($html->image("fugue/clipboard-list.png")." ".__("Company Owner:", true)." ".$X["name"], "/companies/view/".$X["id"], array("class" => "actionbtn", "escape" => false));
								}
							}
							
							if(!isset($employed)){
								echo "<div class='actionbtn'>".$html->image("fugue/cross.png")." ".__("Unemployed", true)."</div>";
							}
						?>

					</td>
					<td>TODO</td>
					<td>
						<?php
							if($data["Newspaper"]['id']) {
								echo $html->link($html->image("fugue/newspaper.png")." ".__("NP:", true)." ".$data["Newspaper"]["name"], "/newspapers/view/".$data["Newspaper"]["id"], array("escape" => false, "class" => "actionbtn"));
							}
						?>
					</td>
				</tr>
			</table>
			<br />
			<h3><?php __("Skills"); ?></h3>
				<table class='grid_skill_table'>
					<tr>
						<td class='grid_skill_table_title' colspan='2'><?php __("Economy Skills"); ?></td>
					</tr>
					<?php
						foreach(array('producer', 'harvester', 'architect') as $X) {
					?>
						<tr>
							<td class='grid_skill_table_name'>
								<?php
									echo $html->image("fugue/folder-open-document.png")." ";
									if($X == "producer") {
										__("Producer");
									}
									elseif($X == "harvester") {
										__("Harvester");
									}
									elseif($X == "architect") {
										__("Architect");
									}
								?>
							</td>
							<td class='grid_skill_table_value'>
								<?php
									$rating = $formulas->economy_skillLevelRating($data["User"][$X."_skill"]);
									$nextP = $formulas->economy_maxSkillPoint($data["User"][$X."_skill"]);
									$currP = $data["User"][$X."_skill"];
									echo "<span class='grid_skill_table_value_level'>".$rating."</span> &middot; ";
									echo " ".$currP."/".$nextP." ".__("Skill Points", true)." (".round($currP/$nextP*100, 2)."%)";
								?>
							</td>
						</tr>
					<?php
						}
					?>
					<tr>
						<td class='grid_skill_table_title' colspan='2'><?php __("Military Skills"); ?></td>
					</tr>
					<tr>
						<td class='grid_skill_table_name'>
							<?php
								echo $html->image("fugue/hard-hat-military.png")." ".__("Military Skill", true);
							?>
						</td>
						<td class='grid_skill_table_value'>
							<?php
								$rating = $formulas->military_skillLevelRating($data["User"]["military_skill"]);
								$nextP = $formulas->military_maxSkillPoint($data["User"]["military_skill"]);
								$currP = $data["User"]["military_skill"];
								echo "<span class='grid_skill_table_value_level'>".$rating."</span> &middot; ";
								echo " ".$currP."/".$nextP." ".__("Skill Points", true)." (".round($currP/$nextP*100, 2)."%)";
							?>
						</td>
					</tr>
				</table>
				<br />
			<?php
			// is this yourself?, or, if you are an admin?
			if($ID == $userdata["User"]["id"] || $userdata["User"]["role"] == "admin") {
				?>
					<h3><?php __("Finances"); ?></h3>
					<table class='data_table user_finance_data_table sortable'>
						<tr>
							<th>
								<?php __("Currency"); ?>
							</th>
							<th><?php __("Amount"); ?></th>
						</tr>

						<tr>
							<td>
								<?php echo $html->image("silk/platinum.png"); ?>
								<?php __("Platinum"); ?>
							</td>
							<td><?php echo $data["User"]["platinum"]; ?></td>
						</tr>
						
						<?php
							foreach($userdata["Account"] as $X) {
								?>
									<tr>
										<td class='sidebar_table_type'>
											<?php echo $html->image("flags/".$countriesindexedlist[$X["Currency"]["country_id"]].".png", array("class" => "country_flag_mini")); ?>
											<?php echo $X["Currency"]["name"]; ?>
										</td>
										<td>
											<?php echo $X["amount"]; ?>
										</td>
									</tr>
								<?php
							}
						?>
					</table>

					<br />
					<h3><?php __("Inventory"); ?></h3>
						<table class='data_table region_data_table'>
							<tr>
								<th><?php __("Item Type"); ?></th>
								<th><?php __("Item Quality"); ?></th>
								<th><?php __("Actions"); ?></th>
							</tr>
							<?php
							// let's show the user's inventory, but first, unserialize it...
							$Inventory = unserialize($data["Inventory"]["inventory_data"]);
							// go through it and parse things as we go..
							foreach($Inventory as $IDX => $X) {
								$i_item_type = ""; $i_item_quality = "";
								sscanf($X, "q%d_%s", $i_item_quality, $i_item_type);
								?>
									<tr>
										<td><?php __(ucfirst($i_item_type)); ?></td>
										<td>
											<?php echo $i_item_quality; ?>
											<table class='progmeter'>
												<tr>
													<td width="<?php echo 16*$i_item_quality; ?>px" class="progmeter-active green"></td>
													<td width="<?php echo 80-(16*$i_item_quality); ?>px" class="progmeter-inactive"></td>
												</tr>
											</table>
										</td>
										<td>
											<?php
												if($i_item_type == "food") {
													echo $html->link(__("Consume Food", true), "/users/consumefood/".$csrf_token."/".$X, array("class" => "button blue small"));
												}
											?>
											<?php echo $html->link(__("Delete Item", true), "/inventories/deleteself/".$X."/".$csrf_token, array("class" => "button red small"), __("Are you sure you want to delete an item? You could just donate it to someone.", true)); ?>
										</td>
									</tr>
								<?php
							}
							?>
						</table>
						<br /><br />
				<?php
			}
			?>
		</td>
	</tr>
</table>