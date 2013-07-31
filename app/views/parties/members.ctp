<?php
	if(($viewCache = Cache::read("party_view_members_{$ID}")) === false) {
		?>
		<h2><?php __("Viewing Members:"); ?> <?php echo $data["Party"]["name"]; ?></h2>
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
							<td class='sidebar_table_special_type'><?php __("Members"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo count($data["Member"]); ?>
							</td>
						</tr>
					</table>
				</td>
				<td class='layout_table_content'>
						<?php
							// loop through each member and show their data
							foreach($data["Member"] as $X) {
								?>
									<div class='profile_special_intro'>
										<span>
											<?php echo $html->image("silk/award_star_silver_2.png"); ?>
											<?php echo __("Congress Member:", true)." ".$X["username"]; ?>
										</span>
										<p><?php __("Congress Member elected on:"); echo " ".$data["Country"]["Congress"]["Congress"]["created_on"]; ?></p>
									</div>
								<?php
							}
						?>
				</td>
			</tr>
		</table>
		<?php
		$viewCache = ob_get_contents();
		ob_end_clean();
		Cache::write("party_view_members_{$ID}", $viewCache, "longest");
	}
	echo $viewCache;