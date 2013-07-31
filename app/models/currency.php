<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.7
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Currency extends AppModel {
	var $name = "Currency";
	
	var $belongsTo = array(
		"Country"
	);

	var $hasMany = array(
		"Account",
		"Company_account"
	);
}
