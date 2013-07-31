<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */
 
class UsersController extends AppController {
	var $name = "Users";
	
	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow("login", "register", "logout", "captcha");
	}

	/*
	 * Community: Forums System
	 * This is a bridge between FluxBB and our user system. The scheme is simple. After a user has access to the Grid, you can get a forum account. Wee! A forum account!
	 * Basically, when the user is created, the forum account is not. Only when the user first accesses the forum, the user will have an account. Fun method, right?
	 */
	function forums() {
		$userHasForumAccount = count($this->User->query("SELECT * from f_users WHERE username = '".$this->Auth->user("username")."'"));
		if($userHasForumAccount > 0) {
			$this->redirect("http://dimensiongrid.com/forum");
			exit;
		}

		if(!empty($this->data) && isset($this->data["forum_pass"])) {
			$Args = func_get_args();

			$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

			// Start CSRF Verification
			// CSRF token?
			if(!$this->Session->read("System.csrf_token") or !isset($Args[0])) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}
			
				if($this->Session->read("System.csrf_token") != $Args[0]) {
					$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
					exit;
				}

			// remove the previous CSRF token
			$this->Session->delete("System.csrf_token");
			// END CSRF Verification

			if(strlen($this->data["forum_pass"]) < 6) {
				$this->redirect(array("controller" => "users", "action" => "forums"));
			}

			$forumPass = sha1($this->data["forum_pass"]);
			$this->User->query("INSERT INTO f_users(`id`, `group_id`, `username`, `password`, `email`) VALUES(NULL, 4, '".$this->Auth->user("username")."', '".$forumPass."', '".$this->Auth->user("email")."')");

			$this->redirect("http://dimensiongrid.com/forum");
			exit;
		}
	}

	/**
	 * Time management functions
	 */
	function dotimemanager() {
		// PROCESS time management data
		$Args = func_get_args();
		if(count($Args) < 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$Action = $Args[0];

		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

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

		if(!isset($this->data["amount"]) || !isset($this->data["booster"])) {
			// well, we don't know what to do...
			$this->redirect(array('controller' => 'users', 'action' => 'timemanager'));
			exit;
		}

		// check whether we have these hours..
		$HoursAvailable = 24-$this->Timemanagement->getUsedHours($this->Auth->user("id"));

		$this->data["amount"] = intval($this->data["amount"]);

		if($this->data["amount"] < 1) {
			$this->Session->setFlash(__("Sorry, you must use atleast one hour!", true), "flash_failure");
			$this->redirect(array("controller" => "users", "action" => "timemanager"));
			exit;
		}

		if($HoursAvailable < $this->data["amount"]) {
			$this->Session->setFlash(__("Sorry, you don't have enough hours.", true), "flash_failure");
			$this->redirect(array("controller" => "users", "action" => "timemanager"));
			exit;
		}

		switch($Action) {
			case "train":
				$boosterPrice = $this->Formulas->economy_getBoosterPrice($this->data["booster"]);

				// Are we using a booster? Erm, you know that you want the proper booster price charged on you.
				$trnsP = $this->User->deductPlatinum($boosterPrice, $this->Auth->user("id"));

				if(!$trnsP) {
					$this->Session->setFlash(__("Sorry, the booster you selected costs more Platinum than the amount you have, try selecting a cheaper one.", true), "flash_failure");

					$this->redirect(array("controller" => "companies"));
					exit;
				}

				// Now, just get the productivity and get going!
				$EXPGain = $this->Formulas->economy_trainExpGain($userdata["User"]["military_skill"], $this->data["amount"], $this->data["booster"], $userdata["User"]["health"]);
				$this->User->id = $this->Auth->user("id");
				$this->User->saveField("military_skill", $userdata["User"]["military_skill"] + $EXPGain);

				// Lose ONE health.
				$this->User->saveField("health", $userdata["User"]["health"] - 1);

				// Deduct time.
				$this->Timemanagement->performTask($userdata["User"]["id"], "train", $this->data["amount"]);

				// ..redirect to results page after saving things
				// things are saved in our userdata variable now through TM class
				$this->Timemanagement->recordTaskResults($userdata["User"]["id"], array("productivity" => $EXPGain, "hours" => $this->data["amount"], "booster" => $this->data["booster"]), "train");

				$this->redirect(array('controller' => 'users', 'action' => 'trainresult'));

			break;
			
			case "study":
				// check some vars
				if(!isset($this->data["skillsel"])) {
					$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
					exit;
				}

				$boosterPrice = $this->Formulas->economy_getBoosterPrice($this->data["booster"]);

				// Are we using a booster? Erm, you know that you want the proper booster price charged on you.
				$trnsP = $this->User->deductPlatinum($boosterPrice, $this->Auth->user("id"));

				if(!$trnsP) {
					$this->Session->setFlash(__("Sorry, the booster you selected costs more Platinum than the amount you have, try selecting a cheaper one.", true), "flash_failure");

					$this->redirect(array("controller" => "companies"));
					exit;
				}

				// Now, just get the productivity and get going!
				$EXPGain = $this->Formulas->economy_studyExpGain($userdata["User"][$this->data["skillsel"]."_skill"], $this->data["amount"], $this->data["booster"], $userdata["User"]["health"]);
				$this->User->id = $this->Auth->user("id");
				$this->User->saveField($this->data["skillsel"]."_skill", $userdata["User"][$this->data["skillsel"]."_skill"] + $EXPGain);

				// Lose ONE health.
				$this->User->saveField("health", $userdata["User"]["health"] - 1);

				// Deduct time.
				$this->Timemanagement->performTask($userdata["User"]["id"], "study", $this->data["amount"]);

				// ..redirect to results page after saving things
				// things are saved in our userdata variable now through TM class
				$this->Timemanagement->recordTaskResults($userdata["User"]["id"], array("productivity" => $EXPGain, "hours" => $this->data["amount"], "booster" => $this->data["booster"]), "study");

				$this->redirect(array('controller' => 'users', 'action' => 'studyresult'));

			break;

			case "work":
				if(($companydata = Cache::read("company_".$userdata["Employee_set"]["company_id"])) === false) {
					$companydata = $this->User->Employee_set->Company->find(
						"first",
						array(
							"conditions" => array(array("Company.id" => $userdata["Employee_set"]["company_id"])),
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

					Cache::write("company_".$userdata["Employee_set"]["company_id"], $companydata, "medium");
				}

				// Handle Company Working Systems.
				$productivity = $this->Formulas->economy_productivityCalc(
					$userdata["Employee_set"]["Company"]["level"], 
					$userdata["User"]["health"], 
					$userdata["User"][$this->Formulas->economy_getWorkType($userdata["Employee_set"]["Company"]["industry"])."_skill"], 
					$this->data["booster"], 
					$this->data["amount"], 
					$userdata["Employee_set"]["Company"]["industry"], 
					$companydata["Region"]["wood_level"], 
					$companydata["Region"]["titanium_level"], 
					$companydata["Region"]["grain_level"], 
					$companydata["Region"]["oil_level"]
				);

				$skillGain = $this->Formulas->economy_expGainAfterWork($productivity, $companydata["Company"]["level"]);

				$boosterPrice = $this->Formulas->economy_getBoosterPrice($this->data["booster"]);

				// User's native account id
				foreach($userdata["Account"] as $A) {
					if($A["Currency"]["country_id"] == $userdata["User"]["citizenship"]) $userNativeAccountID = $A["id"];
				}

				// Are we in a RM (Raw Material) industry? This is the easiest.
				if($companydata["Company"]["industry"] == "wood" || $companydata["Company"]["industry"] == "grain" || $companydata["Company"]["industry"] == "titanium" || $companydata["Company"]["industry"] == "oil") {
					// Pay the Salary first,
					// But make sure it works, OTHERWISE...
					$trns = $this->User->Employee_set->Company->Company_account->transferFromCompanyToUser($userdata["User"]["hourly_wage"] * $this->data["amount"], $companydata["Company_account"]["id"], $userNativeAccountID);

					if(!$trns) {
						$this->Session->setFlash(__("Sorry, you cannot work because this company does not have enough money to pay you. Try again later or find a new company.", true), "flash_failure");

						$this->redirect(array("controller" => "companies"));
						exit;
					}

					// Are we using a booster? Erm, you know that you want the proper booster price charged on you.
					$trnsP = $this->User->deductPlatinum($boosterPrice, $this->Auth->user("id"));

					if(!$trnsP) {
						$this->Session->setFlash(__("Sorry, the booster you selected costs more Platinum than the amount you have, try selecting a cheaper one.", true), "flash_failure");

						// Remember to revert the above payment system
						$trns = $this->User->Employee_set->Company->Company_account->transferFromUserToCompany($userdata["User"]["hourly_wage"] * $this->data["amount"], $userNativeAccountID, $companydata["Company_account"]["id"]);

						$this->redirect(array("controller" => "companies"));
						exit;
					}

					$this->User->Employee_set->Company->id = $userdata["Employee_set"]["company_id"];
					$this->User->Employee_set->Company->saveField("rm_stock", $companydata["Company"]["rm_stock"] + $productivity);

					// Deduct hours, using the timemanagement component
					$this->Timemanagement->performTask($userdata["User"]["id"], "work", $this->data["amount"]);

					// SkillGain
					$this->User->id = $this->Auth->user("id");
					$this->User->saveField($this->Formulas->economy_getWorkType($userdata["Employee_set"]["Company"]["industry"])."_skill", $userdata["User"][$this->Formulas->economy_getWorkType($userdata["Employee_set"]["Company"]["industry"])."_skill"] + $skillGain);

					// Health Loss
					// There's always $quality health lost. Period, done.
					$this->User->saveField("health", $userdata["User"]["health"] - $companydata["Company"]["level"]);

					$this->Session->write("Work.productivity", $productivity);
					$this->Session->write("Work.hours", $this->data["amount"]);
					$this->Session->write("Work.skillGain", $skillGain);

					$this->redirect(array("controller" => "companies", "action" => "result"));
					exit;
				}
				else {
					// Production industry fun is fun

					// Pay the Salary first,
					// But make sure it works, OTHERWISE...
					$trns = $this->User->Employee_set->Company->Company_account->transferFromCompanyToUser($userdata["User"]["hourly_wage"] * $this->data["amount"], $companydata["Company_account"]["id"], $userNativeAccountID);

					if(!$trns) {
						$this->Session->setFlash(__("Sorry, you cannot work because this company does not have enough money to pay you. Try again later or find a new company.", true), "flash_failure");

						$this->redirect(array("controller" => "companies"));
						exit;
					}

					// Are we using a booster? Erm, you know that you want the proper booster price charged on you.
					$trnsP = $this->User->deductPlatinum($boosterPrice, $this->Auth->user("id"));

					if(!$trnsP) {
						$this->Session->setFlash(__("Sorry, the booster you selected costs more Platinum than the amount you have, try selecting a cheaper one.", true), "flash_failure");

						// Remember to revert the above payment system
						$trns = $this->User->Employee_set->Company->Company_account->transferFromUserToCompany($userdata["User"]["hourly_wage"] * $this->data["amount"], $userNativeAccountID, $companydata["Company_account"]["id"]);

						$this->redirect(array("controller" => "companies"));
						exit;
					}

					// Deduct the necessary raw materials for Production.
					// If there aren't enough raw materials, you would stop and REVERT all actions, once again.
					$RMStock = $companydata["Company"]["rm_stock"];
					$RMNeeded = $this->Formulas->economy_numberOfRawNeededPerUnit($companydata["Company"]["industry"], $companydata["Company"]["level"]) * $productivity;
					if($RMStock < $RMNeeded) {
						$this->Session->setFlash(__("Sorry, this production company does not have the enough raw materials to satisfy your productivity, try again later.", true), "flash_failure");

						// Remember to revert the above payment system
						$trns = $this->User->Employee_set->Company->Company_account->transferFromUserToCompany($userdata["User"]["hourly_wage"] * $this->data["amount"], $userNativeAccountID, $companydata["Company_account"]["id"]);
						$trnsP = $this->User->increasePlatinum($boosterPrice, $this->Auth->user("id"));

						$this->redirect(array("controller" => "companies"));
						exit;
					}

					$this->User->Employee_set->Company->id = $userdata["Employee_set"]["company_id"];
					$this->User->Employee_set->Company->saveField("rm_stock", $companydata["Company"]["rm_stock"] - $RMNeeded);
					$this->User->Employee_set->Company->saveField("stock", $companydata["Company"]["stock"] + $productivity);


					// Deduct hours, using the timemanagement component
					$this->Timemanagement->performTask($userdata["User"]["id"], "work", $this->data["amount"]);

					// SkillGain
					$this->User->id = $this->Auth->user("id");
					$this->User->saveField($this->Formulas->economy_getWorkType($userdata["Employee_set"]["Company"]["industry"])."_skill", $userdata["User"][$this->Formulas->economy_getWorkType($userdata["Employee_set"]["Company"]["industry"])."_skill"] + $skillGain);

					// Health Loss
					// There's always $quality health lost. Period, done.
					$this->User->saveField("health", $userdata["User"]["health"] - $companydata["Company"]["level"]);
					
					// ..redirect to results page after saving things
					// things are saved in our userdata variable now through TM class
					$this->Timemanagement->recordTaskResults($userdata["User"]["id"], array("productivity" => $productivity, "hours" => $this->data["amount"], "booster" => $this->data["booster"], "skillGain" => $skillGain), "work");


					$this->redirect(array("controller" => "companies", "action" => "result"));
					exit;
				}

				Cache::delete("company_".$userdata["Employee_set"]["company_id"]);

			break;
		}
	}

	function timemanager() {
		// Shows the map of what the user has been doing.
		// All data is ready anyway; so the view will take care of things
	}

	function library() {
		// this is only a view; the actual thing happens in /dotimemanager.
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
		if($userdata["User"]["task_studied"] != 0) {
			$this->redirect(array("controller" => "users", "action" => "studyresult"));
			exit;
		}
		
		$this->set("maxstudytime", (24-$this->Timemanagement->getUsedHours($this->Auth->user("id")) > 12 ? 12 : 24-$this->Timemanagement->getUsedHours($this->Auth->user("id"))));
	}

		function studyresult() {
			$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
			if($userdata["User"]["task_studied"] == 0) {
				$this->redirect(array("controller" => "users", "action" => "library"));
				exit;
			}
		}

	function training() {
		// this is only a view; the actual thing happens in /dotimemanager.
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
		if($userdata["User"]["task_trained"] != 0) {
			$this->redirect(array("controller" => "users", "action" => "trainresult"));
			exit;
		}

		$this->set("maxtraintime", (24-$this->Timemanagement->getUsedHours($this->Auth->user("id")) > 12 ? 12 : 24-$this->Timemanagement->getUsedHours($this->Auth->user("id"))));
	}

		function trainresult() {
			$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
			if($userdata["User"]["task_trained"] == 0) {
				$this->redirect(array("controller" => "users", "action" => "training"));
				exit;
			}
		}

	/**
	 * Food Consumption Function
	 */
	function consumefood() {
		// PROCESS time management data
		$Args = func_get_args();
		if(count($Args) < 2) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$FoodToEat = $Args[1];
		if($FoodToEat != "q1_food" && $FoodToEat != "q2_food" && $FoodToEat != "q3_food" && $FoodToEat != "q4_food" && $FoodToEat != "q5_food") {
			die($FoodToEat);
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

		// Start CSRF Verification
		// CSRF token?
		if(!$this->Session->read("System.csrf_token") or !isset($Args[0])) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
			if($this->Session->read("System.csrf_token") != $Args[0]) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

		// remove the previous CSRF token
		$this->Session->delete("System.csrf_token");
		// END CSRF Verification

		// Get the user's inventory
		$WorkingInventoryReal = unserialize($userdata["Inventory"]["inventory_data"]);
		$WorkingInventoryCopy = $WorkingInventoryReal; // NOT a reference; for foreach uses ONLY.

		if(!in_array($FoodToEat, $WorkingInventoryReal)) {
			$this->Session->setFlash(__("Sorry, you do not have this food unit in your inventory anymore. If you don't have food, try buying some, or select another unit for consumption.", true), "flash_failure");
			$this->redirect(array('controller' => 'users', 'action' => 'consumefood2'));
			exit;
		}

		// Consume this food, first add the health.
		$i_item_type = ""; $i_item_quality = "";
		sscanf($FoodToEat, "q%d_%s", $i_item_quality, $i_item_type);

		$ItemQuality = $i_item_quality;
		$CurrentHealth = $userdata["User"]["health"];

		$HealthGain = $this->Formulas->economy_foodHealthGain($ItemQuality, $CurrentHealth);
		$NewHealth = $HealthGain + $CurrentHealth; // both are (int)s, so no problem here.

		if($NewHealth > 100) $NewHealth = 100; // no more than 100 please.

		$this->User->id = $this->Auth->user('id');
		$this->User->saveField('health', $NewHealth);

		// Remove this item from the inventory
		foreach($WorkingInventoryCopy as $K => $V) {
			if($V == $FoodToEat) {
				unset($WorkingInventoryReal[$K]);
				break; // don't delete all by type D:
			}
		}

		$this->User->Inventory->id = $userdata["Inventory"]["id"];
		$this->User->Inventory->saveField("inventory_data", serialize($WorkingInventoryReal));

		Cache::delete("profile_".$this->Auth->user("id"));

		// Good, out.
		$this->Session->setFlash(__("Food eaten. Health gain: ", true)."<strong>".$HealthGain."</strong>", "flash_success");
		$this->redirect(array('controller' => 'users', 'action' => 'consumefood2'));
		exit;
	}

	function consumefood2() {
		// the view will handle everything!
	}


	/*
	 * Profile View Functions.
	 * ASSUMPTION: The user is logged in (Auth has denied access if the user is not)
	 */
	function view() {
		$Args = func_get_args();
		if(count($Args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		$ID = intval($Args[0]);
		$this->set("ID", $ID);
		
		// We use the userdata component in order to do things.
		// The profile view is not cached because the logic done in the view is not much and not worth the file system overhead.
		// Remember that manipulating data in memory is MUCH faster than using the File System.
		$Data = $this->Userdata->getUserDataById($ID);
		if(!$Data) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$this->set("data", $Data);

		// There's some accounts logic going on here so in order to save some little queries (well, number of countries = queries)
		// we just get a find(list) so that we can just match them. saves a loop-di-loop, too.
		if(($countriesIndexedList = Cache::read("countries_indexed_list_shortname")) === false) {
			$countriesIndexedList = $this->User->Region->Country->find("list", array("fields" => array("Country.id", "Country.short_name")));

			Cache::write("countries_indexed_list_shortname", $countriesIndexedList, "longest");
		}
		$this->set("countriesindexedlist", $countriesIndexedList);
	}

	/*
	 * Change Password Function. This is a page to change your own password.
	 * Note that on submit two queries need to be done: The user must enter the old password, and then the new password needs to be entered, too.
	 * Note that to avoid some password saving mechanisms, the old password is [oldpassword], and the new one is [password2].
	 * Remember that form fields are [User][..] format manually written in the ctp files.
	 */
	function changepass() {
		if(!empty($this->data)) {
			$UserData = $this->Userdata->getUserDataById($this->Auth->user("id"));
			$UserOldPass = $this->Auth->password($this->data["User"]["oldpassword"]);
			$UserNewPass = $this->data["User"]["password2"];
			$UserNewPassH = $this->Auth->password($UserNewPass);

			// Make sure the new password matches our standards, <6 chars
			if(strlen($UserNewPass) < 6) {
				$this->Session->setFlash(__("Sorry, your new password must be longer than 6 characters!", true), "flash_failure");
				return;
			}

			// Make sure the old password matches the old, corect password...
			if($UserOldPass != $UserData["User"]["password"]) {
				$this->Session->setFlash(__("Sorry, the old password entered does not match the one in our records, try again.", true), "flash_failure");
				return;
			}

			// erm, are you just 'changing' your password to your old one? let's just save a query...
			if($UserOldPass == $UserNewPassH) {
				$this->Session->setFlash(__("Please enter a password different than the one you have right now!", true), "flash_failure");
				return;
			}

			// All OK? Then go ahead and change it!
			$this->User->id = $this->Auth->user("id");
			$this->User->saveField("password", $UserNewPassH);

			$this->flash(__("Password changed successfully! Remember to use the new password next time you login.", true), "/users/view/".$this->Auth->user("id"));
		}
	}
	
	
	/*
	 * Authenticating Functions.
	 * Those are mostly handled by Auth.
	 */
	function login() {
		// are we authed?
		if($this->Auth->user()) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
	}
	
	function register() {
		// are we authed?
		if($this->Auth->user()) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		// is guest. proceed
		// List of regions for the user to select, along with their countries. ugh, this is one big, fat query!
		if(($regRegionsList = Cache::read("register_regions_list_rc")) === false) {
			$regRegionsList = $this->User->Region->Country->find("all", array("contain" => "Region"));

			Cache::write("register_regions_list_rc", $regRegionsList, "longest");
		}
		$this->set("regionsList", $regRegionsList);

		if(!empty($this->data)) {
			// process the data
			// data structure: $this->data[User] contains username, password, email, region_id. note password is automatically hashed by cakephp.
			// zeroth, lets check if the CAPTCHA matches before we waste anymore CPU cycles...
			if($this->Captcha->check($this->data["User"]["captcha"]) == false) {
				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);

				$this->Session->setFlash(__("Please enter the Human Verification (CAPTCHA) correctly.", true), "flash_failure");

				return;
			}

			// first, verify whether all form fields are submitted and not empty...
			if(empty($this->data["User"]["username"]) || empty($this->data["User"]["email"]) || empty($this->data["User"]["password2"])) {
				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);

				$this->Session->setFlash(__("Sorry, some fields in the form are empty. Please fill in all the fields correctly!", true), "flash_failure");

				return;
			}

			// verify that, erm, the password2 field matches our expectations...
			if(strlen($this->data["User"]["password2"]) < 6) {
				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);

				$this->Session->setFlash(__("Your password must be 6 characters or longer.", true), "flash_failure");

				return;
			}

			// and so it matches, so let's convert password2 to password
			$this->data["User"]["password"] = $this->Auth->password($this->data["User"]["password2"]);
			unset($this->data["User"]["password2"]);

			// check whether the username has special characters, and whether the email matches correctly
			if(preg_match('/[^A-Za-z0-9_\s]/im', $this->data["User"]["username"])) {
				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);

				$this->Session->setFlash(__("Sorry, your username contains special characters! Please remove them.", true), "flash_failure");
				return;
			}

			// make sure the username isn't shorter than 2 characters or longer than 35 chars. Hey, 35 is more than enough
			if(strlen($this->data["User"]["username"]) < 2 || strlen($this->data["User"]["username"]) > 35) {
				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);

				$this->Session->setFlash(__("Sorry, your username must not be longer than 35 characters or shorter than two.", true), "flash_failure");
				return;
			}

			// email/username unique validation
			// validate email sequence here
			if(!filter_var($this->data["User"]["email"], FILTER_VALIDATE_EMAIL)) {
				$this->Session->setFlash(__("Sorry, your email address is invalid!", true), "flash_failure");

				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);
				return;
			}

			// unique username here
			if($this->User->find('first', array("conditions" => array("User.username" => $this->data["User"]["username"])))) {
				$this->Session->setFlash("Sorry, the username you chose is already taken!", "flash_failure");

				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);
				$this->set("s_region_id", $this->data["User"]["region_id"]);
				return;
			}

			// alright, assign the citizenship...
			$CitizenshipID = $this->User->Region->find("first", array("conditions" => array("Region.id" => intval($this->data["User"]["region_id"]))));
			if(!$CitizenshipID) {
				$this->set("s_username", $this->data["User"]["username"]);
				$this->set("s_email", $this->data["User"]["email"]);

				$this->Session->setFlash(__("Invalid data identifier", true), "flash_failure");
				return;
			}

			$CitizenshipID = $CitizenshipID["Region"]["owner_id"];

			$CurrencyID = $this->User->Account->Currency->find("first", array("conditions" => array("Currency.country_id" => $CitizenshipID)));
			$CurrencyID = $CurrencyID["Currency"]["id"];

			// create the user and it's dependencies.
			$this->data["User"]["health"] = 100;
			$this->data["User"]["citizenship"] = $CitizenshipID;
			$this->data["User"]["joined"] = date("Y-m-d h:m:s");
			$this->data["User"]["platinum"] = 25;
			$this->data["User"]["ip"] = $_SERVER['REMOTE_ADDR'];

			// ready to insert.
			$InsertProcedure = $this->User->save($this->data, false, array("username", "password", "email", "health", "citizenship", "joined", "platinum", "region_id", "ip"));
			if(!$InsertProcedure) {
				$this->Session->setFlash(__("Invalid data identifier", true), "flash_failure");
				return;
			}
			else {
				// Alright, the user has been created successfully
				$NewUserID = $this->User->id;
				// create an account with the appropriate currency.
				$this->User->Account->save(
					array(
						"Account" => array(
							"user_id" => $NewUserID,
							"currency_id" => $CurrencyID,
							"amount" => 25
						)
					)
				);

				// create the users' inventory
				$this->User->Inventory->save(
					array(
						"Inventory" => array(
							"user_id" => $NewUserID,
							"inventory_data" => serialize(array())
						)
					)
				);

				// alright. now redirect the user to the log in form... Woo!
				$this->Session->setFlash(__("You are now registered! Please log in with the form below to start playing.", true), "flash_success");
				$this->redirect(array("controller" => "dashboard", "action" => "index"));
			}

			exit;
		}
	}
	
	function logout() {
		$Args = func_get_args();

		// Start CSRF Verification
		// CSRF token?
		if(!$this->Session->read("System.csrf_token") or !isset($Args[0])) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
			if($this->Session->read("System.csrf_token") != $Args[0]) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

		// remove the previous CSRF token
		$this->Session->delete("System.csrf_token");
		// END CSRF Verification
		
		$this->Session->delete("Newspaper");
		$this->Session->delete("Work");
		$this->Session->delete("Train");
		$this->Session->delete("Study");

		$this->redirect($this->Auth->logout());
	}

	/*
	 * CAPTCHA for registration form
	 */
	function captcha() {
		$this->Captcha->image();
	}
}