<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.5
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class PartiesController extends AppController {
	var $name = 'Parties';
	var $helpers = array('decoda');
	
	function index() {
		$userData = $this->Userdata->getUserDataById($this->Auth->user("id"));
		$partyId = $userData["User"]["party_id"];
		$countryId = $userData["User"]["citizenship"];
		$regionCountryId = $userData["Region"]["Country"]["id"];

		$this->set("countryId", $countryId);

		if($countryId != $regionCountryId) {
			// not in native country; die out
			$this->redirect(array("controller" => "parties", "action" => "denied"));
			exit;
		}
		if($partyId != "0") {
			$this->redirect(array("controller" => "parties", "action" => "view", $partyId));
			exit;
		}

		// if the user has no party, show them the party selection page
		// fetch all the parties
		$this->paginate = array(
			'conditions' => array("Party.country_id" => $countryId),
			'limit' => 25,
			'order' => 'Party.found_date DESC'
		);

		$Data = $this->paginate('Party');
		$this->set("data", $Data);
	}

	/**
	 * (Controller Method) Join a party.
	 * THINGS TO CHECK: 1. Is user in native country (citizenship=country_in)? 2. Does the user already have a party? 3. Does this party exist?
	 */
	function join() {
		// Did the person specify what party he wanted to join?
		$Args = func_get_args();
		if(count($Args) < 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$ID = intval($Args[0]);

		// Start CSRF Verification
		// CSRF token?
		if(!$this->Session->read("System.csrf_token") or !isset($Args[1])) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
			if($this->Session->read("System.csrf_token") != $Args[1]) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

		// remove the previous CSRF token
		$this->Session->delete("System.csrf_token");

		// END CSRF Verification
		
		$uid = $this->Auth->user("id");
		$userData = $this->Userdata->getUserDataById($uid);

		$user_party = $userData["User"]["party_id"]; // quick way to check. you don't want to join a party if you already take part of one.
			if($user_party != 0) {
				$this->redirect(array('controller' => 'parties', 'action' => 'index'));
				exit;
			}
		
		// is this user in his native country?
		$countryId = $userData["User"]["citizenship"];
		$regionCountryId = $userData["Region"]["Country"]["id"];
		if($countryId != $regionCountryId) {
			// not in native country; die out
			$this->redirect(array("controller" => "parties", "action" => "denied"));
			exit;
		}
		
		// does this party exist, anyway?
		$partydata = $this->Party->find("first", array("conditions" => array("Party.id" => $ID), "contain" => false));
		if(!$partydata) {
			$this->redirect(array('controller' => 'parties', 'action' => 'index'));
			exit;
		}

		// all checks are OK then - set the user up
		$this->Party->Member->id = $uid;
		$this->Party->Member->saveField("party_id", $ID);

		// ...and flush the cache.
		Cache::delete("profile_{$uid}");

		$this->flash(__("You have successfully joined the party:", true)." ".$partydata["Party"]["name"], "/parties/index");
	}

	function denied() {
		// party denied page: not in native citizenship country; can't participate in politics.
	}

	function admin() {
		$Args = func_get_args();
		if(count($Args) < 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$ID = intval($Args[0]);
		$Action = (isset($Args[1]) ? $Args[1] : "index");

		$this->set("ID", $ID);
		// erm, make sure that you are the real admin of this party.
		$userData = $this->Userdata->getUserDataById($this->Auth->user("id"));
		$partyId = $userData["User"]["party_id"];

		if($ID != $partyId) { // not even this party?
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		if($userData["Party"]["leader_id"] != $userData["User"]["id"]) { // not the leader?
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		// the party admin page isn't cached because there isn't much to show... anyways.
		// the presentation logic is handled in admin.ctp. We just have to send the data; they will know which page to display.
		$Data = $this->Party->find("first", 
			array(
				"conditions" => array(
					"Party.id" => $ID
				),
				"contain" => array(
					"Founder",
					"Member",
					"Country" => array(
						"President"
					)
				)
			)
		);
		
		if(!$Data) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
		// in order to make sure that we force a SQL join on the Country.Congress.User table, we fetch congressmen individually with a condition.
		// this is to save query number and performance
		$Congress = $this->Party->Country->Congress->find("first", array("conditions" => array("Congress.country_id" => $Data["Party"]["country_id"]), "contain" => "User"));
		// ... then join it back in
		$Data["Country"]["Congress"] = $Congress;
		
		$this->set("data", $Data);

		$this->set("action", $Action);
		switch($Action) {
			case "index":
				
			break;

			case "editdesc":
				if(!empty($this->data)) {
					if(isset($this->data["Party"]["party_desc"])) {
						$this->Party->id = $ID;
						$this->Party->saveField("party_desc", $this->data["Party"]["party_desc"]);

						$this->flash(__("Party Description Updated!", true), "/parties/admin/".$ID."/editdesc");

						// flush the cache - remember this
						Cache::delete("party_view_{$ID}");
					}

					// the view has $data, which is enough
				}
			break;
		}
	}

	function quit() {
		// oh wait, you're quitting your party? WHAT? :(
		// we don't have to worry much about this; just edit the field in the user's table and we are done.
		$UID = $this->Auth->user("id");
		$userData = $this->Userdata->getUserDataById($UID);
		$ID = $userData["Party"]["id"]; // party id

		// note that if this user is the LEADER of the party, he won't be able to quit.
		// check whether the user is the leader. don't be selfish...
		$partyData = $this->Party->find("first", array("conditions" => array("Party.id" => $ID), "contain" => false));
		if(!$partyData) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		if($partyData["Party"]["leader_id"] == $UID) {
			// you can't go!
			$this->flash(__("Sorry, you are not allowed to quit your party because you are the Party Leader.", true), "/parties");
		}
		else {
			$this->Party->Member->id = $UID;
			$this->Party->Member->saveField("party_id", 0);

			// ...and flush the cache.
			Cache::delete("profile_{$UID}");

			$this->flash(__("You have now quitted your party.", true), "/parties");
		}
	}
	
	function view() {
		$Args = func_get_args();
		if(count($Args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$ID = intval($Args[0]);

		$this->set("ID", $ID);
		if(($viewCache = Cache::read("party_view_{$ID}")) === false) {
			$Data = $this->Party->find("first", 
				array(
					"conditions" => array(
						"Party.id" => $ID
					),
					"contain" => array(
						"Founder",
						"Member",
						"Leader",
						"Country" => array(
							"President"
						)
					)
				)
			);
			
			if(!$Data) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}
			
			// in order to make sure that we force a SQL join on the Country.Congress.User table, we fetch congressmen individually with a condition.
			// this is to save query number and performance
			$Congress = $this->Party->Country->Congress->find("first", array("conditions" => array("Congress.country_id" => $Data["Party"]["country_id"]), "contain" => "User"));
			// ... then join it back in
			$Data["Country"]["Congress"] = $Congress;
			
			$this->set("data", $Data);
		}
		else {
			$this->set("data", false); // hey, you're cached; do your own job.
		}
	}
}