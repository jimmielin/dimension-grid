<h2><?php __("Time Management: Training Field"); ?></h2>
<p><?php __("Hey there. Ready for some really, really hard training? It will be good for your military skill. Go ahead and change. You don't want to practice with a tie."); ?></p>

<?php
	if(24 - $userdata["User"]["time_spent"] < 1) {
		?>
			<p class='error'>
				<?php echo $html->image("fugue/cross.png"); ?>
				<?php __("Sorry, you can't train because you do not have enough hours."); ?>
			</p>
		<?php
	}
	else {
		echo $form->create(false, array("url" => "/users/dotimemanager/train/".$csrf_token));
?>
<table class='company_employee_controls train_controls train_controls_adapted'>
	<tr>
		<td class='company_employee_controls_topleft'>
			<?php __("Please select the number of hours you would like to train for"); ?>
		</td>
		<td class='company_employee_controls_topright' align='right' width='150px'>
			<input id='amount' name='data[amount]' type='hidden' />
			<button class='button large black nomarg' type='submit'><?php echo $html->image("fugue/books-stack.png"); ?> <?php __("Study!"); ?></button>
		</td>
	</tr>

	<tr>
		<td class='company_employee_controls_slider'>
			<div id='company_employee_controls_slider_ui'></div>
			<div id='amount-display'></div>
		</td>
		<td>
			
		</td>
	</tr>
	<tr>
		<td class='company_employee_controls_selbooster' colspan='2'>
			<strong><?php __("Select a booster that you want to use"); ?></strong>
			<?php $plt = $html->image("silk/platinum.png"); ?>
			<table class='booster_select_table'>
				<tr>
					<td width='25%'>
						<div class='booster_select_table_td booster_select_table_td_active' id='trainpack'>
							<span><?php echo $html->image("fugue/luggage.png"); ?> <?php __("Training Pack"); ?></span> (<?php echo $plt; ?> 0.0 PLT)
							<p><?php __("Getting ready for everything will boost your training result by 10%."); ?></p>
						</div>
					</td>

					<td width='25%'>
						<div class='booster_select_table_td' id='hardhat'>
							<span><?php echo $html->image("fugue/hard-hat.png"); ?> <?php __("Hard Hat"); ?></span> (<?php echo $plt; ?> 0.4 PLT)
							<p><?php __("You never know when something falls on the top of you. Less injuries will boost your training result by 50%."); ?></p>
						</div>
					</td>

					<td width='25%'>
						<div class='booster_select_table_td' id='mildiary'>
							<span><?php echo $html->image("fugue/film.png"); ?> <?php __("Military Diary"); ?></span> (<?php echo $plt; ?> 0.9 PLT)
							<p><?php __("Know how they did it before, and you will give yourself a 120% result boost."); ?></p>
						</div>
					</td>

					<td width='25%'>
						<div class='booster_select_table_td' id='finalparty'>
							<span><?php echo $html->image("fugue/party-hat.png"); ?> <?php __("Final Party"); ?></span> (<?php echo $plt; ?> 2.0 PLT)
							<p><?php __("After some rough training, you need to get your smile back. A party at the end will boost your result by 300%!"); ?></p>
						</div>
					</td>
				</tr>
			</table>

			<input type='hidden' name='data[booster]' id='booster' value='stickynotes' />
		</td>
	</tr>
</table>
</form>

<script type='text/javascript'>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('x l(f,c,p){i n=0,v=\'\',7=\'\',6=\'\',g=0,C=F;i G=x(b,h,w){4(w===A){4(h===V){4((b%2)===1){4(h>=5){b++}a{b--}}}a 4(h>=5){b++}}a{4(h===5){4((b%2)===0){4(h>=5){b++}a{b--}}}a 4(h>=5){b++}}j b};i H=x(b,h,y){4(y===A){4(h>=5){b++}}a{4(h>5){b++}}j b};i t=x(f,e,p){i v=f.I(),B=0,D=0;i g=v.P(\'.\');i 8=0,m=0;i 7=\'\',6=\'\';i l=R,s=F;K(p){d\'y\':s=A;d\'M\':l=H;q;d\'w\':s=A;d\'J\':l=G;q}4(e<0){B=v.o;e=B+e;m=9(v.r(e));8=9(v.r(e-1));8=l(8,m,s);v=v.k(0,e-1);D=B-v.o-1;4(8===u){v=W(9(v)+1)+\'0\'}a{v+=8}v=9(v)*(z.E(u,D))}a 4(e>0){7=v.k(0,g);6=v.k(g+1);m=9(6.r(e));8=9(6.r(e-1));8=l(8,m,s);6=6.k(0,e-1);4(8===u){v=9(7+\'.\'+6)+(1*(z.E(u,(0-6.o))))}a{v=9(7+\'.\'+6+8)}}a{7=v.k(0,g);6=v.k(g+1);m=9(6.r(e));8=9(7.r(7.o-1));8=l(8,m,s);6=\'0\';7=7.k(0,7.o-1);4(8===u){v=9((9(7)+1)+6)}a{v=9(7+8)}}j v};4(Q c===\'O\'){c=0}4(Q p===\'O\'){p=\'L\'}C=f<0;v=z.N(f).I();g=v.P(\'.\');4(g===-1&&c>=0){j f}a{4(g===-1){7=v;6=\'0\'}a{7=v.k(0,g);4(c>=0){6=v.X(g+1,c+1)}a{6=\'0\'}}4(c>0&&c>=6.o){j f}a 4(c<0&&z.N(c)>=7.o){j 0}4(6===\'0\'){j 9(7)}f=9(7+\'.\'+6)}K(p){d 0:d\'L\':n=t(f,c,\'y\');q;d 1:d\'T\':n=t(f,c,\'M\');q;d 2:d\'S\':n=t(f,c,\'w\');q;d 3:d\'U\':n=t(f,c,\'J\');q}j C?0-n:n}',60,60,'||||if||decimal|integer|digitToRound|Number|else|dtR|precision|case|decplaces|val|decp|dtLa|var|return|slice|round|digitToLookAt|retVal|length|mode|break|charAt|bool|_round_half|10||even|function|up|Math|true|vlen|negative|vlenDif|pow|false|_round_half_oe|_round_half_ud|toString|odd|switch|PHP_ROUND_HALF_UP|down|abs|undefined|indexOf|typeof|null|PHP_ROUND_HALF_EVEN|PHP_ROUND_HALF_DOWN|PHP_ROUND_HALF_ODD|50|String|substr'.split('|'),0,{}))
	$("#company_employee_controls_slider_ui").slider({
		range: "min",
		value: 1,
		min: 1,
		max: <?php echo $maxtraintime; ?>,
		slide: function(event, ui) {
			$("#amount").val(ui.value);
			$("#amount-display").html(ui.value + ' <?php __("Hours"); ?>');
		}
	});

	$("#amount").val(1);
	$("#amount-display").html(1 + ' <?php __("Hours"); ?>');
	// booster management
	$(".booster_select_table_td").click(function() {
		var boosterSelected = $(this).attr("id");
		$(".booster_select_table_td").removeClass("booster_select_table_td_active").filter("#" + boosterSelected).addClass("booster_select_table_td_active");
		$("#booster").val(boosterSelected);
	});
</script>
<?php } ?>