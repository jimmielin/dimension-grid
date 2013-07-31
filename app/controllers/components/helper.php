<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.2
 * @license   Dimension.Grid Shared-Source Components License
 * @copyright (c) 2010 Jimmie Lin
 */

class HelperComponent extends Object {
	var $controller;

	function startup(&$controller) {
		$this->controller = $controller;
		if(isset($controller->actionHelpers)) {
			$this->pushHelpers();
		}
	}

	function pushHelpers() {
		foreach($this->controller->actionHelpers as $helper) {
			App::import("Helper", ucfirst($helper));
			$_helperClassName = $helper.'Helper';
			$this->controller->{$helper} = new $_helperClassName();
		}
	}
}