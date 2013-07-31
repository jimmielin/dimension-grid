<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.2
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Newspaper_article extends AppModel {
	var $name = "Newspaper_article";
	
	var $belongsTo = array(
		"Newspaper"
	);

	var $hasMany = array(
		"Newspaper_comment"
	);
}
