<h2><?php __("Food Consumption"); ?></h2>
<p class='message'><?php echo $html->image("silk/information_gray.png"); ?> 
<?php __("In order to survive in the Grid, you need to consume food. This will recover your health."); ?></p>

<p><?php __("Please select the food unit you would like to consume"); ?></p>
<table class='data_table food_consumption_data_table'>
<tr>
	<th><?php __("Food Quality"); ?></th>
	<th><?php __("Actions"); ?></th>
</tr>
<?php
$foodIcon = $html->image("fugue/cookie-bite.png");
// let's show the user's inventory, but first, unserialize it...
$Inventory = unserialize($userdata["Inventory"]["inventory_data"]);
// go through it and parse things as we go..
foreach($Inventory as $IDX => $X) {
	$i_item_type = ""; $i_item_quality = "";
	sscanf($X, "q%d_%s", $i_item_quality, $i_item_type);
	if($i_item_type != "food") continue;
	?>
		<tr>
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
					echo $html->link($foodIcon." ".__("Consume this food unit", true), "/users/consumefood/".$csrf_token."/".$X, array("class" => "button blue small", "escape" => false));
				?>
			</td>
		</tr>
	<?php
}
?>
</table>