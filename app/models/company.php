<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.5
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Company extends AppModel {
	var $name = "Company";

	var $hasOne = array(
		"Company_account",
		"Employee_set"
	);
	
	var $belongsTo = array(
		"Owner" => array( // Owner.
			"className" => "User"
		),
		"Region" // location
	);

	var $hasMany = array(
		"SellOffer"
	);
}
