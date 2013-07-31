<?php
	if($userdata) {
		$NumAlerts = count($userdata["Alert"]);
		if($NumAlerts > 0) {
			?>
				<div class='info'>
					<?php echo $html->image("silk/information.png"); ?>
					<?php echo $html->link(__("You have new alerts. Click this message to read them.", true), "/alerts"); ?>
				</div>
			<?php
		}
		?>
			<!-- layout table. I know this is ugly. let's solve it later on. -->
			<table class='dashboard_index_table' width='100%'>
				<tr>
					<td width='320px'>
						<h3><?php __("Latest Events"); ?></h3>
							<?php
								foreach($localEvents as $X) {
									?>
										<div class='event_box'>
											<div class='event_box_info'>
												<?php echo $html->image("flags/".$X["Country"]["short_name"].".png"); ?> <?php echo $X["Country"]["long_name"]; ?> &middot;
												<?php echo $html->image("fugue/calendar.png"); ?> <?php echo $X["Event"]["date"]; ?>
											</div>
											<div class='event_box_content'>
												<?php echo $X["Event"]["message"]; ?>
											</div>
										</div><br />
									<?php
								}
							?>


						<div class='sep'></div>
						<h3><?php __("Latest Events (World)"); ?></h3>
							<?php
								foreach($allEvents as $X) {
									?>
										<div class='event_box'>
											<div class='event_box_info'>
												<?php
													if($X["Event"]["country_id"] != "0") 
														echo $html->image("flags/".$X["Country"]["short_name"].".png")." ".$X["Country"]["long_name"]." &middot; ";
												?>
												<?php echo $html->image("fugue/calendar.png"); ?> <?php echo $X["Event"]["date"]; ?>
											</div>
											<div class='event_box_content'>
												<?php echo $X["Event"]["message"]; ?>
											</div>
										</div><br />
									<?php
								}
							?>
							
					</td>
					<td>
						Main Content
					</td>

					<td width='250px'>
						<h3><?php __("My Shouts"); ?></h3>
						<div class='shout_box'>
							<div class='shout_box_info'>
								<?php
									echo $html->image("fugue/user.png")." ";
									echo "<strong>".$userdata["User"]["username"]."</strong>";
								?>
							</div>
							<div class='event_box_content'>
								<?php echo $form->create("Shout", array("url" => "/users/shout")); ?>
									<textarea name='data[Shout][content]' cols='40' rows='2' placeholder='enter your shout here...'></textarea>
									<button class='blue small button' type='submit'><?php __("Shout!"); ?></button>
								</form>
							</div>
						</div><br />
							<?php
								foreach($userdata["Shout"] as $X) {
									?>
										<div class='shout_box'>
											<div class='shout_box_info'>
												<?php
													echo $html->image("fugue/user.png")." ";
													echo "<strong>".$userdata["User"]["username"]."</strong>";
												?>

												<?php echo $html->image("fugue/calendar.png"); ?> <?php echo $X["date"]; ?>
											</div>
											<div class='event_box_content'>
												<?php echo $X["content"]; ?>
											</div>
										</div><br />
									<?php
								}
							?>
					</td>
				</tr>
			</table>
		<?php
	} else { ?>
		<h2><?php __("Welcome to the Grid!"); ?></h2>
		<p>
			TODO Intro Text
		</p>
		<p class='dash_big_advert_btn'>
			<?php echo $html->link(__("Join the Grid!", true), "/users/register", array("class" => "button large green")); ?>
		</p>
	<?php
	}