<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.4
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class RegionsController extends AppController {
	var $name = 'Regions';
	
	function index() {
		$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
	}
	
	function view() {
		$Args = func_get_args();
		if(count($Args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		$ID = intval($Args[0]);

		$this->set("ID", $ID);
		if(($viewCache = Cache::read("region_view_{$ID}")) === false) {
			$Data = $this->Region->find("first", 
				array(
					"conditions" => array(
						"Region.id" => $ID
					),
					"contain" => array(
						"Citizen",
						"Country"
					)
				)
			);

			if(!$Data) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}
			$this->set("data", $Data);
		}
		else {
			$this->set("data", false); // hey, you're cached; do your own job.
		}
	}
}