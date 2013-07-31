<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.2
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Vote extends AppModel {
	var $name = "Vote";
	
	var $belongsTo = array(
		"Election",
		"User" // the user this 'vote' goes to
	);
}
