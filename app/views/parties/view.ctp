<?php
	if(($viewCache = Cache::read("party_view_{$ID}")) === false) {
		ob_start();
		?>
		<h2><?php echo $data["Party"]["name"]; ?></h2>
		<table class='layout_table party_layout_table'>
			<tr>
				<td class='layout_table_left'>
					<!-- todo: party avatar -->
					<table class='sidebar_table_special'>
						<tr>
							<td class='sidebar_table_special_top' colspan='2'>
								<?php echo $data["Party"]["name"]; ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Country"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo $html->image("flags/".$data["Country"]["short_name"].".png", array("class" => "country_flag_mini")); ?>
								<?php echo $html->link($data["Country"]["long_name"], "/countries/view/".$data["Country"]["id"]); ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Members"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo count($data["Member"]); ?>
								<?php /*echo $html->link("[".__("View", true)."]", "/parties/members/".$ID);*/ ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Party Leader"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo $html->link($data["Leader"]["username"], "/users/view/".$data["Leader"]["id"]); ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Party Founder"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo $html->link($data["Founder"]["username"], "/users/view/".$data["Founder"]["id"]); ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Created on"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo $data["Party"]["found_date"]; ?>
							</td>
							</tr>
					</table>
					<br />
					<?php
						if($data["Party"]["leader_id"] == $userdata["User"]["id"]) {
							// the current user is THE party leader
							echo $html->link(
									$html->image("fugue/toolbox.png")." ".__("Party Leader Tools", true),
									"/parties/admin/".$userdata["Party"]["id"],
									array("class" => "actionbtn", "escape" => false)
								);
						}
						// quit party link if we are in the party, ofc
						if($userdata["User"]["party_id"] == $data["Party"]["id"]) {
							echo $html->link($html->image("fugue/cross-circle-frame.png")." ".__("Quit Party", true), "/parties/quit", array("class" => "actionbtn", "escape" => false));
						}
					?>
				</td>
				
				<td class='layout_table_content'>
					<h3><?php __("Party Description"); ?></h3>
						<p class='textblock'><?php echo $decoda->parse($data["Party"]["party_desc"]); ?></p>
						
					<br /><br />
					
					<h3><?php __("Party Leader"); ?></h3>
						<div class='profile_special_intro'>
							<span><?php echo $data["Leader"]["username"]; ?></span>
							<p><?php __("Party Leader Since:"); echo " ".$data["Party"]["last_leader_change"]; ?></p>
						</div>
						
					<br /><br />
					
					<h3><?php __("Political Coverage"); ?></h3>
						<?php
							// is the president a member of this party? probably - may be!
							if($data["Country"]["President"]["party_id"] == $ID) {
								// oh well it is!
								?>
									<div class='profile_special_intro'>
										<span>
											<?php echo $html->image("fugue/medal.png"); ?>
											<?php echo __("Country President:", true)." ".$data["Country"]["President"]["username"]; ?>
										</span>
										<p><?php __("Country President of:"); echo " ".$data["Country"]["long_name"]; ?></p>
									</div>
								<?php
							}
							
							// loop through the congressmen and get the coverage level.
							$ourCongressMbrs = 0;
							$totalCongressMbrs = 0;
							foreach($data["Country"]["Congress"]["User"] as $X) {
								$totalCongressMbrs++;
								
								if($X["party_id"] == $ID) {
									$ourCongressMbrs++;
									?>
										<div class='profile_special_intro'>
											<span>
												<?php echo $html->image("fugue/medal-silver.png"); ?>
												<?php echo __("Congress Member:", true)." ".$X["username"]; ?>
											</span>
											<p><?php __("Congress Member elected on:"); echo " ".$data["Country"]["Congress"]["Congress"]["created_on"]; ?></p>
										</div>
									<?php
								}
							}
							
							// alright - now tell me the coverage please!
							?>
								<br />
								<p>
									<strong><?php __("Total Congressional Coverage:"); ?></strong> <?php if($totalCongressMbrs == 0) echo "0"; else echo round($ourCongressMbrs/$totalCongressMbrs * 100, 2); ?>%
										(<?php echo $ourCongressMbrs."/".$totalCongressMbrs; ?>)
								</p>
							<?php
						?>
				</td>
			</tr>
		</table>
		<?php
		$viewCache = ob_get_contents();
		ob_end_clean();
		Cache::write("party_view_{$ID}", $viewCache, "longest");
	}
	echo $viewCache;