<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Region extends AppModel {
	var $name = "Region";
	var $hasMany = array(
		"Citizen" => array( // habitants
			"className" => "User"
		)
	);
	
	var $belongsTo = array(
		"Country" => array(
			"foreignKey" => "owner_id"
		)
	);
}
