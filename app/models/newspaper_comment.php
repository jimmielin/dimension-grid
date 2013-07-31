<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.976.45
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Newspaper_comment extends AppModel {
	var $name = "Newspaper_comment";
	
	var $belongsTo = array(
		"Newspaper_article",
		"User"
	);
}
