<h2><?php echo $data["Company"]["name"]; ?></h2>
<table class='layout_table party_layout_table'>
	<tr>
		<td class='layout_table_left'>
			<table class='sidebar_table_special'>
				<tr>
					<td class='sidebar_table_special_type'><?php __("Industry"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							switch($data["Company"]["industry"]) {
								case "food":
									echo $html->image("fugue/cookies.png");
									echo " ";
									__("Food");
								break;

								case 'house':
									echo $html->image("fugue/home.png");
									echo " ";
									__("House");
								break;

								case "gift":
									echo $html->image("fugue/store.png");
									echo " ";
									__("Gifts");
								break;

								// ----

								case "wood":
									echo $html->image("fugue/wooden-box.png");
									echo " ";
									__("Wood");
								break;

								case "titanium":
									echo $html->image("fugue/wooden-box.png");
									echo " ";
									__("Titanium");
								break;

								case "grain":
									echo $html->image("fugue/wooden-box.png");
									echo " ";
									__("Grain");
								break;

								case "oil":
									echo $html->image("fugue/wooden-box.png");
									echo " ";
									__("Oil");
								break;

								// ----

								case "defense":
									echo $html->image("fugue/shield.png");
									echo " ";
									__("Defense System");
								break;

								case "hospital":
									echo $html->image("fugue/spray.png");
									echo " ";
									__("Hospital");
								break;
							}
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
					<td class='sidebar_table_special_type'><?php __("Quality"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							for($i=0;$i!=$data["Company"]["level"];$i++) {
								echo $html->image("fugue/star-small.png");
							}
							echo $data["Company"]["level"];
						?>
					</td>
				</tr>

				<tr>
					<td class='sidebar_table_special_topsub' colspan='2'><?php __("Status"); ?></td>
				</tr>

				<tr>
					<td class='sidebar_table_special_type'><?php __("Owner"); ?></td>
					<td class='sidebar_table_special_value'>
						<?php
							echo $data["Owner"]["username"];
						?>
					</td>
				</tr>
			</table>
			<br />
			<?php
				if(isset($is_employee) && $is_employee) {
					?>
						<?php echo $html->link($html->image("fugue/cross-circle-frame.png")." ".__("Resign from company", true), "/companies/quit", array("escape" => false, "class" => "actionbtn")); ?>
					<?php
				}

				if(isset($is_owner) && $is_owner) {
					?>
						<?php echo $html->link($html->image("fugue/clipboard-list.png")." ".__("Manage Company", true), "/companies/manage/".$data["Company"]["id"], array("escape" => false, "class" => "actionbtn")); ?>
					<?php
				}
			?>
		</td>

		<td class='layout_table_content'>
			<?php

				if(isset($is_employee) && $is_employee) {
					if(isset($has_worked) && $has_worked) {
						?>
							<p class='success'>
								<?php echo $html->image('fugue-32/clock.png'); ?>
								<?php __("Welcome to your company! You have already worked today. You can work again tomorrow."); ?>
							</p>
						<?php
					}
					else {
						if($userdata["User"]["health"] < 80) {
							?>
								<p class='warning'>
									<?php echo $html->image('fugue-32/clock.png'); ?>
									<?php __("Welcome to your company! You seem a bit tired right now. You might want to eat some food before working."); ?>
								</p>
							<?php
						}
						else {
							?>
								<p class='info'>
									<?php echo $html->image('fugue-32/clock.png'); ?>
									<?php __("Welcome to your company! You seem very productive today. Go ahead and start working - good luck!"); ?>
								</p>
							<?php
						}
					}
				}
			?>

			<?php
				if((isset($is_employee) && $is_employee) && (!isset($has_worked))) {
					?>
					<?php echo $form->create(false, array("url" => "/users/dotimemanager/work/".$csrf_token)); ?>
						<table class='company_employee_controls'>
							<tr>
								<td class='company_employee_controls_topleft'>
									<?php __("Please select the number of hours you want to work for"); ?>
								</td>
								<td class='company_employee_controls_topright' align='right' width='150px'>
									<?php echo $html->image("fugue/moneys.png"); ?>
									<?php __("Hourly Wage:"); ?>

									<strong><?php echo $userdata["User"]["hourly_wage"]; ?></strong>
									<?php
										foreach($userdata["Account"] as $X) {
											if($X["Currency"]["country_id"] == $userdata["Region"]["Country"]["id"]) {
												echo $X["Currency"]["name"];
											}
										}
									?>
								</td>
							</tr>

							<tr>
								<td class='company_employee_controls_slider'>
									<div id='company_employee_controls_slider_ui'></div>
									<div id='amount-display'></div>
								</td>
								<td>
									<input id='amount' name='data[amount]' type='hidden' />
									<button class='button large black nomarg' type='submit'><?php echo $html->image("fugue/paper-clip.png"); ?> <?php __("Work!"); ?></button>
								</td>
							</tr>
							<tr>
								<td class='company_employee_controls_selbooster' colspan='2'>
									<strong><?php __("Select a booster that you want to use"); ?></strong>
									<?php $plt = $html->image("silk/platinum.png"); ?>
									<table class='booster_select_table'>
										<tr>
											<td width='25%'>
												<div class='booster_select_table_td booster_select_table_td_active' id='morningcoffee'>
													<span><?php echo $html->image("fugue/cup.png"); ?> <?php __("Morning Coffee"); ?></span> (<?php echo $plt; ?> 0.0 PLT)
													<p><?php __("Keeps you awake and boosts your productivity by 10%."); ?></p>
												</div>
											</td>

											<td width='25%'>
												<div class='booster_select_table_td' id='todolist'>
													<span><?php echo $html->image("fugue/clipboard-task.png"); ?> <?php __("To-do List"); ?></span> (<?php echo $plt; ?> 0.2 PLT)
													<p><?php __("Keeping things organized will boost your productivity by 50%."); ?></p>
												</div>
											</td>

											<td width='25%'>
												<div class='booster_select_table_td' id='cookiepack'>
													<span><?php echo $html->image("fugue/cookie-bite.png"); ?> <?php __("Cookie Pack"); ?></span> (<?php echo $plt; ?> 0.7 PLT)
													<p><?php __("Refill your stomach and boost productivity by 100%."); ?></p>
												</div>
											</td>

											<td width='25%'>
												<div class='booster_select_table_td' id='music'>
													<span><?php echo $html->image("fugue/headphone.png"); ?> <?php __("Music"); ?></span> (<?php echo $plt; ?> 1.0 PLT)
													<p><?php __("Good music in the background will boost your productivity by 200%."); ?></p>
												</div>
											</td>
										</tr>
									</table>

									<input type='hidden' name='data[booster]' id='booster' value='morningcoffee' />
								</td>
							</tr>
						</table>
						</form>

						<script type='text/javascript'>
						eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('x l(f,c,p){i n=0,v=\'\',7=\'\',6=\'\',g=0,C=F;i G=x(b,h,w){4(w===A){4(h===V){4((b%2)===1){4(h>=5){b++}a{b--}}}a 4(h>=5){b++}}a{4(h===5){4((b%2)===0){4(h>=5){b++}a{b--}}}a 4(h>=5){b++}}j b};i H=x(b,h,y){4(y===A){4(h>=5){b++}}a{4(h>5){b++}}j b};i t=x(f,e,p){i v=f.I(),B=0,D=0;i g=v.P(\'.\');i 8=0,m=0;i 7=\'\',6=\'\';i l=R,s=F;K(p){d\'y\':s=A;d\'M\':l=H;q;d\'w\':s=A;d\'J\':l=G;q}4(e<0){B=v.o;e=B+e;m=9(v.r(e));8=9(v.r(e-1));8=l(8,m,s);v=v.k(0,e-1);D=B-v.o-1;4(8===u){v=W(9(v)+1)+\'0\'}a{v+=8}v=9(v)*(z.E(u,D))}a 4(e>0){7=v.k(0,g);6=v.k(g+1);m=9(6.r(e));8=9(6.r(e-1));8=l(8,m,s);6=6.k(0,e-1);4(8===u){v=9(7+\'.\'+6)+(1*(z.E(u,(0-6.o))))}a{v=9(7+\'.\'+6+8)}}a{7=v.k(0,g);6=v.k(g+1);m=9(6.r(e));8=9(7.r(7.o-1));8=l(8,m,s);6=\'0\';7=7.k(0,7.o-1);4(8===u){v=9((9(7)+1)+6)}a{v=9(7+8)}}j v};4(Q c===\'O\'){c=0}4(Q p===\'O\'){p=\'L\'}C=f<0;v=z.N(f).I();g=v.P(\'.\');4(g===-1&&c>=0){j f}a{4(g===-1){7=v;6=\'0\'}a{7=v.k(0,g);4(c>=0){6=v.X(g+1,c+1)}a{6=\'0\'}}4(c>0&&c>=6.o){j f}a 4(c<0&&z.N(c)>=7.o){j 0}4(6===\'0\'){j 9(7)}f=9(7+\'.\'+6)}K(p){d 0:d\'L\':n=t(f,c,\'y\');q;d 1:d\'T\':n=t(f,c,\'M\');q;d 2:d\'S\':n=t(f,c,\'w\');q;d 3:d\'U\':n=t(f,c,\'J\');q}j C?0-n:n}',60,60,'||||if||decimal|integer|digitToRound|Number|else|dtR|precision|case|decplaces|val|decp|dtLa|var|return|slice|round|digitToLookAt|retVal|length|mode|break|charAt|bool|_round_half|10||even|function|up|Math|true|vlen|negative|vlenDif|pow|false|_round_half_oe|_round_half_ud|toString|odd|switch|PHP_ROUND_HALF_UP|down|abs|undefined|indexOf|typeof|null|PHP_ROUND_HALF_EVEN|PHP_ROUND_HALF_DOWN|PHP_ROUND_HALF_ODD|50|String|substr'.split('|'),0,{}))
							$("#company_employee_controls_slider_ui").slider({
								range: "min",
								value: 8,
								min: 1,
								max: <?php echo $maxworktime; ?>,
								slide: function(event, ui) {
									$("#amount").val(ui.value);
									$("#amount-display").html(ui.value + ' <?php __("Hours"); ?> (<?php __("Salary:"); ?> ' + round(ui.value*<?php echo $userdata["User"]["hourly_wage"]; ?>, 2) +  ")");
								}
							});

							$("#amount").val(8);
							$("#amount-display").html(8 + ' <?php __("Hours"); ?> (<?php __("Salary:"); ?> ' + 8*<?php echo $userdata["User"]["hourly_wage"]; ?> +  ")");
							// booster management
							$(".booster_select_table_td").click(function() {
								var boosterSelected = $(this).attr("id");
								$(".booster_select_table_td").removeClass("booster_select_table_td_active").filter("#" + boosterSelected).addClass("booster_select_table_td_active");
								$("#booster").val(boosterSelected);
							});
						</script>
					<?php
				}
			?>
			<br />

			<!-- sell offers (if any) -->
			<h3><?php __("Market Offers"); ?></h3>
			<?php
				if(count($marketoffers) == 0) {
					?>
						<p class='message'>
							<?php echo $html->image("silk/information_gray.png"); ?>
							<?php __("There are no market offers posted by this company."); ?>
						</p>
					<?php
				}
				else {
					?>
						<table class='market_offer_table'>
							<tr>
								<th><?php __("Amount"); ?></th>
								<th><?php __("Price per Unit"); ?></th>
								<th><?php __("Country"); ?></th>
							</tr>
							<?php
								foreach($marketoffers as $X) {
									?>
										<tr>
											<td><?php echo $X["Sell_offer"]["amount"]; ?></td>
											<td><?php echo $X["Sell_offer"]["price_per_unit"]; ?></td>
											<td>
												<?php 
													echo $html->image("flags/".$data["Region"]["Country"]["short_name"].".png", array("class" => "country_flag_mini"))." ";
													echo $html->link($data["Region"]["Country"]["long_name"], "/countries/view/".$data["Region"]["Country"]["id"]);
												?>
											</td>
										</tr>
									<?php
								}
							?>
						</table>
					<?php
				}
				?>
			<br />

			<!-- production information -->
			<table width='100%'>
				<tr>
					<td width='50%'>
						<div class='work_result_div work_result_div_adapted_companyview'>
							<strong><?php echo $html->image("fugue/chart-up-color.png"); ?> <?php __("Products Made (In stock):"); ?></strong>
								<?php
									if($data["Company"]["industry"] == "wood" || $data["Company"]["industry"] == "grain" || $data["Company"]["industry"] == "titanium" || $data["Company"]["industry"] == "oil") {
										echo $data["Company"]["rm_stock"] . " (".floor($data["Company"]["rm_stock"])." ".__("Usable", true).")";
									}
									else {
										echo $data["Company"]["stock"] . " (".floor($data["Company"]["stock"])." ".__("Usable", true).")";
										?>
											<br />
											<strong><?php echo $html->image("fugue/box.png"); ?> <?php __("Raw Materials Stock"); ?></strong>
										<?php
											echo $data["Company"]["rm_stock"] . " (<strong>".__("RM per Unit", true)."</strong>: ".$formulas->economy_numberOfRawNeededPerUnit($data["Company"]["industry"], $data["Company"]["level"]).")";
									}
								?>
						</div>
					</td>
					<td>
						<div class='work_result_div work_result_div_adapted_companyview'>
							<strong><?php echo $html->image("fugue/users.png"); ?> <?php __("No. of Employees:"); ?></strong>
								<?php
									echo count($data["Employee_set"]["Employee"]);
								?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>