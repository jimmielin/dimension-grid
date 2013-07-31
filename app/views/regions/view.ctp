<?php
	if(($viewCache = Cache::read("region_view_{$ID}")) === false) {
		ob_start();
		$Population = count($data["Citizen"]);
		?>
		<h2><?php echo $data["Region"]["name"]; ?></h2>
		<table class='layout_table region_layout_table'>
			<tr>
				<td class='layout_table_left'>
					<?php echo $html->image("flags-48/".$data["Country"]["short_name"].".png", array("class" => "country_flag_big")); ?>
					<table class='sidebar_table_special'>
						<tr>
							<td class='sidebar_table_special_top' colspan='2'>
								<?php echo $html->image("flags/".$data["Country"]["short_name"].".png", array("class" => "country_flag_mini")); ?>
								<?php echo $data["Region"]["name"]; ?>
							</td>
						</tr>
						<tr>
							<td class='sidebar_table_special_type'><?php __("Population"); ?></td>
							<td class='sidebar_table_special_value'>
								<?php
									echo $Population;
								?>
							</td>
						</tr>
					</table>
				</td>
				
				<td class='layout_table_content'>
					<h3><?php __("Region Information"); ?></h3>
					<table class='data_table region_data_table'>
						<tr>
							<th colspan='2'><?php __("Infrastructure"); ?></th>
							<th colspan='4'><?php __("Resources"); ?></th>
						</tr>
						<tr>
							<th><?php __("Hospital"); ?></th>
							<th><?php __("Defense System"); ?></th>
							
							<th><?php __("Grain"); ?></th>
							<th><?php __("Wood"); ?></th>
							<th><?php __("Titanium"); ?></th>
							<th><?php __("Oil"); ?></th>
						</tr>
						
						
						<tr>
							<td><?php echo $data["Region"]["hospital_level"]; ?></td>
							<td><?php echo $data["Region"]["defense_level"]; ?> (<strong><?php __("Hit Points:"); ?></strong> <?php echo $formulas->military_defenseSystemHitPoints($data["Region"]["defense_level"], $Population); ?>)</td>
							
							<td><?php echo $formulas->economy_resourceLevelRating($data["Region"]["grain_level"])." (".$data["Region"]["grain_level"].")"; ?></td>
							<td><?php echo $formulas->economy_resourceLevelRating($data["Region"]["wood_level"])." (".$data["Region"]["wood_level"].")"; ?></td>
							<td><?php echo $formulas->economy_resourceLevelRating($data["Region"]["titanium_level"])." (".$data["Region"]["titanium_level"].")"; ?></td>
							<td><?php echo $formulas->economy_resourceLevelRating($data["Region"]["oil_level"])." (".$data["Region"]["oil_level"].")"; ?></td>
						</tr>
						
					</table>
					
					<br />
					<h3><?php __("Political Status"); ?></h3>
					<p>TODO</p>
				</td>
			</tr>
		</table>
		<?php
		$viewCache = ob_get_contents();
		ob_end_clean();
		Cache::write("region_view_{$ID}", $viewCache, "long");
	}
	echo $viewCache;