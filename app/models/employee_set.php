<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.5
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Employee_set extends AppModel {
	var $name = "Employee_set";
	var $hasMany = array(
		"Employee" => array(
			"className" => "User"
		)
	);

	var $belongsTo = array(
		"Company"
	);
}
