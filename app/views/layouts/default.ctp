<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo Configure::read("Appl.Name"); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<?php
		echo $html->meta('icon');

		echo $html->meta('description', "Dimension.Grid is an online multiplayer game which gives you a second life, in a virtual world called the Grid. You and many other players build a virtual world together, and conquer other countries together.");
		echo $html->meta('keywords', 'online,game,gridlife,grid,dimensiongrid,dimension,social,political,military,mmo,php,mysql,cakephp,jimmielin,jimmie,games,internet,life,secondlife');

		echo $html->css('reset'); echo $html->css('global');
		echo $html->css('jqueryui/jqueryui_184.css');
		echo $javascript->link("jquery");
		echo $javascript->link("colortip");
		echo $javascript->link("jqueryui");
		
		if(substr($_SERVER["HTTP_USER_AGENT"], 0, 34) != "Mozilla/5.0 (compatible; MSIE 9.0;") { // detect msie/9.0 because it hates canvas
			echo $javascript->link("cufon"); echo $javascript->link("font");
		}
		echo $javascript->link("sortable");
		
		echo $javascript->link("global");
		echo $scripts_for_layout;
	?>
	<!--[if IE 6]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js">IE7_PNG_SUFFIX=".png";</script>
	<![endif]-->
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18215826-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
	<div id="header">
		<div id="branding">
			<?php echo $html->link($html->image("logo.png"), "/", array("escape" => false)); ?>
		</div>
		<div id="userbar">
			<?php
				if($userdata) {
					echo __("Welcome back,", true)."&nbsp;<strong>".$userdata["User"]["username"]."</strong>&nbsp;";
					echo $html->link("[".__("Logout", true)."]", "/users/logout");
				}
				else {
					echo __("Welcome Guest!", true)."&nbsp;".$html->link("[".__("Login", true)."]", "/users/login")."&nbsp;".$html->link("[".__("Register", true)."]", "/users/register");
				}
			?>
			|
			<span>
				<?php
					echo $html->image("fugue/calendar-day.png");
					echo " ".date("Y-m-d h:m:s")." (Day <strong>".floor((time() - 1283299200)/60/60/24)."</strong> of the Grid)";
				?>
			</span>
		</div>
		<br class='clearfix' />
		<?php if($userdata != false): ?>
		<ul id='navmenu'>
			<?php $dmt = $html->image("silk/bullet_arrow_down.png"); ?>
			<li class='navitem'>
				<?php echo $html->image("fugue/home.png"); ?>
				<?php echo $html->link(__("Home", true), "/"); ?>
			</li>
			<li class='navitem' id='navmenu-places'>
				<span id='navmenu-places-a'>
					<?php echo $html->image("fugue/globe.png"); ?>
					<a href='#places'><?php __("Places"); ?></a>
					<?php echo $dmt; ?>
				</span>
				
				<ul class='navmenu-sub' id='navmenu-sub-places'>
					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/user.png"); ?>
						<?php echo $html->link(__("My Profile", true), "/users/view/".$userdata["User"]["id"]); ?>
					</li>
					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/users.png"); ?>
						<?php echo $html->link(__("My Party", true), "/parties"); ?>
					</li>
					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/clock.png"); ?>
						<?php echo $html->link(__("Time Management", true), "/users/timemanager"); ?>
					</li>

					<li class='navmenu-sub-sep'>&nbsp;</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/building.png"); ?>
						<?php echo $html->link(__("My Company", true), "/companies"); ?>
					</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/books-stack.png"); ?>
						<?php echo $html->link(__("Library", true), "/users/library"); ?>
					</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/hard-hat-military.png"); ?>
						<?php echo $html->link(__("Training Field", true), "/users/training"); ?>
						</li>
				</ul>
			</li>
			<li class='navitem' id='navmenu-events'>
				<span id='navmenu-events-a'>
					<?php echo $html->image("fugue/flag-blue.png"); ?>
					<a href='#actions'><?php __("Actions"); ?></a>
					<?php echo $dmt; ?>
				</span>
				
				<ul class='navmenu-sub' id='navmenu-sub-events'>
					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/store.png"); ?>
						<?php echo $html->link(__("Marketplace", true), "/selloffers"); ?>
					</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/building--pencil.png"); ?>
						<?php echo $html->link(__("Job Market", true), "/joboffers"); ?>
					</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/money-coin.png"); ?>
						<?php echo $html->link(__("Monetary Market", true), "/moneyoffers"); ?>
					</li>

					<li class='navmenu-sub-sep'>&nbsp;</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/script.png"); ?>
						<?php echo $html->link(__("Elections", true), "/elections"); ?>
					</li>

				</ul>
			</li>
			<li class='navitem' id='navmenu-social'>
				<span id='navmenu-social-a'>
					<?php echo $html->image("fugue/balloons.png"); ?>
					<a href='#social'><?php __("Social"); ?></a>
					<?php echo $dmt; ?>
				</span>
				
				<ul class='navmenu-sub' id='navmenu-sub-social'>
					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/newspaper.png"); ?>
						<?php echo $html->link(__("My Newspaper", true), "/newspapers/own"); ?>
					</li>

					<li class='navmenu-sub-sep'>&nbsp;</li>

					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/balloon-quotation.png"); ?>
						<?php echo $html->link(__("Community Forums", true), "/users/forums"); ?>
					</li>
					<li class='navmenu-sub-item'>
						<?php echo $html->image("fugue/chart.png"); ?>
						<?php echo $html->link(__("Grid Statistics", true), "/dashboard/stats"); ?>
					</li>
				</ul>
			</li>

		</ul>
		<?php endif; ?>
	</div>
	<table width="100%" id="container">
		<tr>
			<td id="sidebar">
				<h2><?php __("Sidebar"); ?></h2>
				<?php
					if($userdata) {
						?>
							<table class='sidebar_table' width='100%'>
								<tr>
									<td colspan='2' class='sidebar_table_top'>
										<?php echo $html->link($html->image("fugue/user.png")." ".$userdata["User"]["username"], "/users/view/".$userdata["User"]["id"], array("escape" => false)); ?>
									</td>
								</tr>
									<tr>
										<td class='sidebar_table_type'><?php __("Citizenship"); ?></td>
										<td class='sidebar_table_value'>
											<?php
												$csflag = $html->image("flags/".$userdata["Citizenship"]["short_name"].".png");
												echo $csflag;
											?>
											<?php echo $html->link($userdata["Citizenship"]["long_name"], "/countries/view/".$userdata["Citizenship"]["id"]); ?>
										</td>
									</tr>
									<tr>
										<td class='sidebar_table_type'><?php __("Location"); ?></td>
										<td class='sidebar_table_value'>
											<?php echo $html->image("flags/".$userdata["Region"]["Country"]["short_name"].".png"); ?>
											<?php
												echo $html->link($userdata["Region"]["name"], "/regions/view/".$userdata["Region"]["id"]).", ".
												$html->link($userdata["Region"]["Country"]["long_name"], "/countries/view/".$userdata["Region"]["id"]);
											?>
										</td>
									</tr>
									<tr>
										<td class='sidebar_table_type'><?php __("Health"); ?></td>
										<td class='sidebar_table_value'>
											<?php echo $html->image("fugue/plus-circle-frame.png"); ?>
											<?php echo $userdata["User"]["health"]; ?>%
										</td>
									</tr>
								<tr>
									<td colspan='2' class='sidebar_table_topsub'>
										<?php echo $html->image("fugue/money.png"); ?>
										<?php __("Finances"); ?>
									</td>
								</tr>
									<tr>
										<td class='sidebar_table_type'>
											<?php echo $html->image("silk/platinum.png"); ?>
											<?php __("Platinum"); ?>
										</td>
										<td class='sidebar_table_value'>
											<?php echo $userdata["User"]["platinum"]; ?>
										</td>
									</tr>
									<!-- show the user's PRIMARY currency, and only that. thank you. -->
									<?php
										foreach($userdata["Account"] as $X) {
											if($X["Currency"]["country_id"] == $userdata["Region"]["Country"]["id"]) {
												?>
													<tr>
														<td class='sidebar_table_type'>
															<?php echo $csflag; ?>
															<?php echo $X["Currency"]["name"]; ?>
														</td>
														<td class='sidebar_table_value'>
															<?php echo $X["amount"]; ?>
														</td>
													</tr>
												<?php	
											}
										}
									?>
							</table>
							<br	/>
							<?php
								echo $html->link($html->image("fugue/cookie-bite.png")." ".__("Consume Food", true), "/users/consumefood2/", array("class" => "button blue small", "escape" => false));
							?>
							<br /><br />
							<?php

								if($userdata["Citizenship"]["president_id"] == $userdata["User"]["id"]) {
									// the current user is the president
									echo $html->link(
											$html->image("fugue/wrench.png")." ".__("President Tools", true),
											"/countries/admin/".$userdata["Citizenship"]["id"], 
											array("class" => "actionbtn", "escape" => false)
										);
								}

								if($userdata["User"]["congress_id"] != "0") {
									// the current user is a congress member
									echo $html->link(
											$html->image("fugue/wrench.png")." ".__("Congress Tools", true),
											"/countries/admin/".$userdata["Citizenship"]["id"],
											array("class" => "actionbtn", "escape" => false)
										);
								}

								if($userdata["Party"]["leader_id"] == $userdata["User"]["id"]) {
									// the current user is a party leader
									echo $html->link(
											$html->image("fugue/toolbox.png")." ".__("Party Leader Tools", true),
											"/parties/admin/".$userdata["Party"]["id"],
											array("class" => "actionbtn", "escape" => false)
										);
								}
							?>
							<br />
							<a href="<?php echo Router::url("/", true); ?>alerts" class="actionbtn">
								<?php echo $html->image("fugue/bell.png"); ?>
								<?php
									$NumAlerts = count($userdata["Alert"]);
									if($NumAlerts == 0) {
										__("No Alerts");
									}
									else {
										__("Alerts");
										echo " (".$NumAlerts.")";
									}
								?>
							</a>
							<br />
						<?php

						echo $html->link(__("Logout", true), "/users/logout/".$csrf_token, array("class" => "button red small"));
					}
					else {
						echo $form->create('User', array('action' => 'login'));
						echo $form->input('username', array('div' => false, 'label' => "U: "))."<br />";
						?>
							<label for="UserPassword">P: </label><input type="password" name="data[User][password]" id="UserPassword" value='' /><br />
							<button class='button navy medium' type='submit'><?php __('Login'); ?></button>
						<?php
						echo $html->link(__("Register", true), "/users/register", array('class' => 'button darkblue medium'));
						echo $form->end();
					}
				?>
			</td>
			<td id="content">
				<?php
					$flash = $this->Session->flash();
					if($flash) {
						echo $flash;
						echo "<br />";
					}
				?>
				<?php echo $content_for_layout; ?>
			</td>
		</tr>
	</table>
	<div id="footer">
		<div id="footer_bar">
			<?php echo $html->image("fugue/clock.png"); ?>
			<?php global $TIME_START; echo round(getMicrotime() - $TIME_START, 4)."s"; ?>

			&middot;

			<?php echo $html->image("fugue/script.png"); ?>
			<?php echo $html->link("Usage Terms", "/pages/terms"); ?>

			<?php echo $html->image("fugue/information.png"); ?>
			<?php echo $html->link("Credits", "/pages/credits"); ?>

			<?php echo $html->image("fugue/question-white.png"); ?>
			<?php echo $html->link("FAQ", "/pages/faq"); ?>

			&middot;

			<?php echo $html->image("animuson.png"); ?>
			Hosting sponsored by <a href='http://animuson.com'>Animuson Productions</a>

			&middot;

			<?php echo $html->image("fugue/cake.png"); ?>
			Powered by <a href='http://cakephp.org'>CakePHP</a>
		</div>
		<div id="copyright">
		<strong><?php echo Configure::read("Appl.Name"); ?></strong> Version <strong><?php echo Configure::read("Appl.Version"); ?></strong> &copy; 2010 Jimmie Lin
		</div>
	</div>
	<br />
	<?php /**/echo $this->element('sql_dump'); ?>
</body>
</html>
