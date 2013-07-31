<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.2
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class ElectionsController extends AppController {
	var $name = "Elections";

	function index() {
		// Make sure the user can access political systems.
		$userData = $this->Userdata->getUserDataById($this->Auth->user("id"));
		$countryId = $userData["User"]["citizenship"];
		$regionCountryId = $userData["Region"]["Country"]["id"];

		$this->set("countryId", $countryId);

		if($countryId != $regionCountryId) {
			// not in native country; die out
			$this->redirect(array("controller" => "parties", "action" => "denied"));
			exit;
		}

		// Display the list of the elections in the current user's country.
		if(($Elections = Cache::read("elections_".$userData["User"]["citizenship"])) === false) {
			$Elections = $this->Election->find(
				"all", array(
					"conditions" => array(
						"Election.country_id" => $userData["User"]["citizenship"]
					),
					"contain" => "Vote"
				)
			);

			Cache::write("elections_".$userData["User"]["citizenship"], $Elections, "short");
		}

		$this->set("elections", $Elections);
	}
}