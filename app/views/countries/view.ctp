<?php
	// for performance purposes, the entire page below is cached in the country_view_$id caching variable, and is 'long'.
	// this will keep the country view cached for 1 hour and this will yield significant improvements in performance.
	// when the cache is incorrect, $data is passed to us so we can mess with it and cache the country view.
	// there *still* are problems with this implementation, but it's the best way for performance, AND consistency.
	if(($countryView = Cache::read("country_view_{$ID}")) === false) {
		ob_start();
		$miniflag = $html->image("flags/".$data["Country"]["short_name"].".png", array("class" => "country_flag_mini"));
		?>
		<h2><?php echo $data["Country"]["long_name"]; ?></h2>
		<table class='layout_table country_layout_table'>
			<tr>
				<td class='layout_table_left'>
					<?php echo $html->image("flags-48/".$data["Country"]["short_name"].".png", array("class" => "country_flag_big")); ?>
					<table class='sidebar_table_special'>
						<tr>
							<td class='sidebar_table_special_top' colspan='2'>
								<?php echo $miniflag; ?>
								<?php echo $data["Country"]["long_name"]; ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Citizenships"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo count($data["User"]); ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Population"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php
									$populationCount = 0;
									foreach($data["Region"] as $X) {
										$populationCount = $populationCount + count($X["Citizen"]);
									}

									echo $populationCount;
								?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Currency"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo $miniflag; ?>
								<?php echo $data["Currency"]["name"]; ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_topsub' colspan='2'>
								<?php __("Political Status"); ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("President"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php echo $html->link($data["President"]["username"], "/users/view/".$data["President"]["id"]); ?>
							</td>
						</tr>
					</table>
				</td>
				<td class='layout_table_content'>
					<h3><?php __("Regions"); ?></h3>
					<table class='data_table country_region_list_table sortable'>
						<tr>
							<th><?php __("Region Name"); ?></th>
							<th><?php __("Population"); ?></th>
							<th><?php __("Hospital"); ?></th>
							<th><?php __("Defense System"); ?></th>
						</tr>
						<?php
							$regionsTable = "";
							foreach($data["Region"] as $X) {
								$Population = count($X["Citizen"]);
								$regionsTable .= "<tr>";
									$regionsTable .= "<td>".$html->link($X["name"], "/regions/view/".$X["id"])."</td>";
									$regionsTable .= "<td>".$Population."</td>";
									$regionsTable .= "<td>".$X["hospital_level"]."/5</td>";
									$regionsTable .= "<td>".$X["defense_level"]."/5 (<strong>".__("Hit Points", true).":</strong> ".$formulas->military_defenseSystemHitPoints($X["defense_level"], $Population).")</td>";
								$regionsTable .= "</tr>";
							}
							echo $regionsTable;
						?>
					</table>
				</td>
			</tr>
		</table>
		<?php
		$countryView = ob_get_contents();
		ob_end_clean();
		Cache::write("country_view_{$ID}", $countryView, "long");
	}
	
	// after this caching routine, output it.
	echo $countryView;