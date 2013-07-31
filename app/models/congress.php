<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.5
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Congress extends AppModel {
	var $name = "Congress";
	
	var $belongsTo = array(
		"Country"
	);
	
	var $hasMany = "User";
}
