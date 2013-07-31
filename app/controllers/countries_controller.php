<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class CountriesController extends AppController {
	var $name = 'Countries';
	
	function index() {
		$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
	}
	
	function view() {
		$Args = func_get_args();
		if(count($Args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		$CountryID = intval($Args[0]);
		
		// "With great power, comes great responsibility". Make sure you cache things correctly and don't duplicate caching code.
		// The caching approach we are taking is simple. We check if our view is cached. If yes, we don't feed the data to the view anymore.
		// If no, you know; just feed the data in and it will generate the cache up.
		// Feed the country ID to the view so it can identify it
		$this->set("ID", $CountryID);
		if(($viewCache = Cache::read("country_view_{$CountryID}")) === false) {
			$Data = $this->Country->find("first", 
				array(
					"conditions" => array(
						"Country.id" => $CountryID
					),
					"contain" => array(
						"Region.Citizen",
						"User",
						"President",
						"Currency"
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