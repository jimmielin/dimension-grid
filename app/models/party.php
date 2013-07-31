<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.5
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Party extends AppModel {
	var $name = "Party";
	var $displayField = "name";

	var $hasMany = array(
		"Member" => array( // party members
			"className" => "User"
		)
	);
	
	var $belongsTo = array(
		"Leader" => array(
			"foreignKey" => "leader_id",
			"className" => "User"
		),
		"Founder" => array(
			"foreignKey" => "founder_id",
			"className" => "User"
		),
		"Country"
	);
}
