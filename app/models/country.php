<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Country extends AppModel {
	var $name = "Country";
	var $hasMany = array(
		"User" => array( // citizenship key
			"foreignKey" => "citizenship"
		),
		"Region" => array( // regions
			"foreignKey" => "owner_id"
		),
		"Event"
	);
	
	var $hasOne = array(
		"Congress",
		"Currency"
	);
	
	var $belongsTo = array(
		"President" => array( // We are using belongsTo because this is a one-way sided thingy
			"className" => "User",
			"foreignKey" => "president_id"
		)
	);
}
