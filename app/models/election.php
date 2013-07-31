<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.2
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Election extends AppModel {
	var $name = "Election";
	
	var $belongsTo = array(
		"Country"
	);

	var $hasMany = array(
		"Vote"
	);
}
