<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.5
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class CompaniesController extends AppController {
	var $name = "Companies";

	function index() {
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

		if($userdata["User"]["employee_set_id"] != "0") {
			// redirect to own company
			$this->redirect(array("controller" => "companies", "action" => "view", $userdata["Employee_set"]["company_id"]));
		}
	}

	/**
	 * View Company */

	function view() {
		$Args = func_get_args();
		if(count($Args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		$ID = intval($Args[0]);
		$this->set("ID", $ID);

		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

		if(($companydata = Cache::read("company_$ID")) === false) {
			$companydata = $this->Company->find(
				"first",
				array(
					"conditions" => array(array("Company.id" => $ID)),
					"contain" => array(
						"Owner",
						"Employee_set.Employee",
						"Region.Country",
						"Company_account"
					)
				)
			);

			if(!$companydata) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

			Cache::write("company_$ID", $companydata, "medium");
		}
		$this->set("data", $companydata);

		// it really depends on some things. if the user is an employee of this company, more details will be shown.
		if($userdata["Employee_set"]["Company"]["id"] == $ID) {
			$this->set("is_employee", true);

			if($userdata["User"]["task_worked"] != 0) {
				$this->set("has_worked", true);
			}
			else {
				// get the user's available hours
				$this->set("maxworktime", (24-$this->Timemanagement->getUsedHours($userdata["User"]["id"]) > 12 ? 12 : 24-$this->Timemanagement->getUsedHours($userdata["User"]["id"])));
			}
		}

		// market offers.
		if(($marketoffers = Cache::read("market_offers_$ID")) === false) {
			$marketoffers = $this->Company->Sell_offer->find(
				"all",
				array(
					"conditions" => array(array("Sell_offer.company_id" => $ID))
				)
			);

			Cache::write("market_offers_$ID", $marketoffers, "medium");
		}

		$this->set("marketoffers", $marketoffers);

		// owner system

		if($userdata["Employee_set"]["Company"]["owner_id"] == $userdata["User"]["id"]) {
			$this->set("is_owner", true);
		}
	}

	/**
	 * Well, let's say manage/admin a company */
	function manage() {
		$Args = func_get_args();
		if(count($Args) < 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$ID = intval($Args[0]);
		$Action = (isset($Args[1]) ? $Args[1] : "index");

		$this->set("ID", $ID);
		// erm, make sure that you are the real admin of this..
		$userData = $this->Userdata->getUserDataById($this->Auth->user("id"));

		// the party admin page isn't cached because there isn't much to show... anyways.
		// the presentation logic is handled in admin.ctp. We just have to send the data; they will know which page to display.
		$Data = $this->Company->find("first", 
			array(
				"conditions" => array(
					"Company.id" => $ID
				),
				"contain" => array(
					"Employee_set.Employee",
					"Owner"
				)
			)
		);
		
		if(!$Data) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
		$this->set("data", $Data);

		$this->set("action", $Action);
		switch($Action) {
			case "index":
				
			break;
		}
	}

	function result() {
		$userData = $this->Userdata->getUserDataById($this->Auth->user("id"));
		
		if($userData["User"]["task_worked"] == "0") {
			$this->redirect(array("controller" => "companies", "action" => "index"));
			exit;
		}
	}
}