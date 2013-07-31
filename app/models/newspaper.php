<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.2
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Newspaper extends AppModel {
	var $name = "Newspaper";
	
	var $belongsTo = array(
		"User",
		"Country"
	);

	var $hasMany = array(
		"Newspaper_article"
	);
}
