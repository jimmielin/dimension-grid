<h2><?php echo $data["Newspaper"]["name"]; ?></h2>
<table class='layout_table party_layout_table'>
	<tr>
		<td class='layout_table_left'>
			<table class='sidebar_table_special'>
				<tr>
					<td class='sidebar_table_special_type'><?php __("Owner"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							echo $data["User"]["username"];
						?>
					</td>
				</tr>
				<tr>
					<td class='sidebar_table_special_type'><?php __("Country"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							echo $html->image("flags/".$data["Country"]["short_name"].".png", array("class" => "country_flag_mini"))." ";
							echo $html->link($data["Country"]["long_name"], "/countries/view/".$data["Country"]["id"]);
						?>
					</td>
				</tr>
			</table>
			<br />
			<?php
				if($data["Newspaper"]["trustseal"] == "1") {
					?>
						<div class='success'>
							<?php echo $html->image("fugue/trophy.png"); ?>
							<?php echo $html->link(__("Trusted Publisher", true)." (?)", "/newspapers/trust"); ?>
						</div>
						<br />
					<?php
				}

				if($userdata["User"]["id"] == $data["User"]["id"]) {
					echo $html->link($html->image("fugue/newspaper--plus.png")." ".__("New Article", true), "/newspapers/write", array("escape" => false, "class" => "actionbtn"));
					echo $html->link($html->image("fugue/newspaper--pencil.png")." ".__("Edit Newspaper", true), "/newspapers/edit", array("escape" => false, "class" => "actionbtn"));
				}
			?>
		</td>

		<td class='layout_table_content'>
			<?php
				foreach($articles as $X) {
					$commentNum = count($X["Newspaper_comment"]);
					?>
						<a href='<?php echo Router::url("/newspapers/article/".$X["Newspaper_article"]["id"], true); ?>'><h3><?php echo $X["Newspaper_article"]["title"]; ?></h3></a>
						<div class='newspaper_article'>
							<div class='newspaper_article_info'>
								<?php echo $html->image("fugue/user.png"); ?> <strong><?php __("Author:"); ?></strong> <?php echo $data["User"]["username"]; ?>
								&middot;

								<?php echo $html->image("fugue/calendar-day.png"); ?> <strong><?php __("Date"); ?></strong> <?php echo $X["Newspaper_article"]["date"]; ?>
								&middot; <?php echo $html->image("fugue/chart-pie-separate.png"); ?> <strong><?php __("Popularity"); ?></strong>
									<?php if(!($session->read("Newspaper.voted_".$X["Newspaper_article"]["id"]) == true)) echo $html->link($html->image("fugue/thumb.png"), "/newspapers/vote/".$X["Newspaper_article"]["id"]."/down/".$csrf_token, array("escape" => false), __("Are you sure you want to vote down this article? Please remember to leave a comment so the author can improve it.", true)); ?>
									<?php echo $X["Newspaper_article"]["votes"]; ?>
									<?php if(!($session->read("Newspaper.voted_".$X["Newspaper_article"]["id"]) == true)) echo $html->link($html->image("fugue/thumb-up.png"), "/newspapers/vote/".$X["Newspaper_article"]["id"]."/up/".$csrf_token, array("escape" => false)); ?>
									&middot;
									<?php echo $html->image("fugue/balloon-quotation.png"); ?>
									<?php echo $html->link(__("View Comments", true)." (".$commentNum.")", "/newspapers/article/".$X["Newspaper_article"]["id"], array("title" => __("Have an opinion on this article? Or you want to view the existing opinions? Click here.", true))); ?>

									&middot;
									<?php if($userdata["User"]["id"] == $data["User"]["id"]) { ?>
										<?php echo $html->image("fugue/pencil.png"); ?>
										<?php echo $html->link(__("Edit Article", true), "/newspapers/edit/".$X["Newspaper_article"]["id"], array("title" => __("You want to improve your own article to make it even better? Go ahead, click here and change it.", true))); ?>
										
										&middot; <?php echo $html->image("fugue/cross-circle-frame.png"); ?>
										<?php echo $html->link(__("Delete Article", true), "/newspapers/delete/".$X["Newspaper_article"]["id"]."/".$csrf_token, array("title" => __("Done it wrong? Just a test? If you don't want this article anymore, I guess you can delete it.", true)), __("Are you sure you want to delete this article? THIS ACTION CANNOT BE UNDONE!", true)); ?>

									<?php } ?>
							</div>
							<p>
								<?php echo $decoda->parse($X["Newspaper_article"]["content"]); ?>
							</p>
						</div>

						<div class='sep'></div>
					<?php	
				}

				if(count($articles) < 1) {
					?>
						<p class='info'>
							<?php __("There are no articles here. Sorry!"); ?>
						</p>
					<?php
				}
			?>
			<br />
			<?php echo $paginator->prev('Previous', array("class" => "button green small"), null, array('class' => 'hidden')); ?>
			<?php echo $paginator->numbers(); ?>
			<?php echo $paginator->next('Next', array("class" => "button green small"), null, array('class' => 'hidden')); ?>
			<?php echo $paginator->counter(); ?>
		</td>
	</tr>
</table>
