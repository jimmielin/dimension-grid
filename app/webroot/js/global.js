Cufon.replace("h2,h3", {textShadow: "text-shadow: 1px 1px #CCC"});
Cufon.replace(".dash_big_advert h4", {textShadow: "text-shadow: 1px 1px #333"});

$().ready(function() {
	/**
	 * Manage the dropdown menus.
	 */
	$("#navmenu-places-a").hover(function() {
		$(".navmenu-sub").stop(true, true).slideUp(0);
		$("#navmenu-sub-places").stop(true, true).slideDown(0);
	});

	$("#navmenu-events-a").hover(function() {
		$(".navmenu-sub").stop(true, true).slideUp(0);
		$("#navmenu-sub-events").stop(true, true).slideDown(0);
	})

	$("#navmenu-social-a").hover(function() {
		$(".navmenu-sub").stop(true, true).slideUp(0);
		$("#navmenu-sub-social").stop(true, true).slideDown(0);
	})
	
	$("#container").mouseover(function() {
		$(".navmenu-sub").stop().slideUp(0);
	});
	
	/* Tooltips */
	$("[title]").colorTip({color:'blue'});

	/*
	 * Register form elements */
	$(".registertable_value select").selectmenu({
		style: 'dropdown',
		width: 160,
		maxHeight: 120
	});
});