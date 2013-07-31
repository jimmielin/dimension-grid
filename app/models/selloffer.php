<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.976.13828
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class SellOffer extends AppModel {
	var $name = "SellOffer";
	
	var $belongsTo = array(
		"Company",
		"Country"
	);
}
