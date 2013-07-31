<h2><?php __("Viewing Market Offers for: "); echo $userdata["Region"]["Country"]["long_name"]; ?></h2>
<table class='market_offer_table'>
	<tr>
		<th><?php __("Amount"); ?></th>
		<th><?php __("Price per Unit"); ?></th>
		<th><?php __("Country"); ?></th>
	</tr>
	<?php
		foreach($data as $X) {
			?>
				<tr>
					<td><?php echo $X["SellOffer"]["amount"]; ?></td>
					<td><?php echo $X["SellOffer"]["price_per_unit"]; ?></td>
					<td>
						<?php 
							echo $html->image("flags/".$userdata["Region"]["Country"]["short_name"].".png", array("class" => "country_flag_mini"))." ";
							echo $html->link($userdata["Region"]["Country"]["long_name"], "/countries/view/".$userdata["Region"]["Country"]["id"]);
						?>
					</td>
				</tr>
			<?php
		}
	?>
</table>