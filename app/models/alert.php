<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.6
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Alert extends AppModel {
	var $name = "Alert";
	
	var $belongsTo = array(
		"User"
	);

	var $order = "Alert.date DESC";
}
