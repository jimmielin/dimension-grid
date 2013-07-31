<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class AppController extends Controller {
	var $helpers = array("Html", "Form", "Session", "Javascript", "Formulas", "Time");
	var $components = array("Auth", "Userdata", "Helper", "Session", "Captcha", "Timemanagement");
	
	var $actionHelpers = array("Formulas");
	
	public static $UserData;
	
	function beforeRender() {
		parent::beforeRender();
		
		$this->Auth->userModel = "User";
		$this->Auth->loginRedirect = array('controller' => 'dashboard', 'action' => 'index');
		
		// this is a way to simulate a user logon, used when we test with PyLot.
		// should be commented out
		//$this->Auth->login(array("username" => "Jimmie Lin", "password" => ""));
		
		// Get the user's information and attach it to userdata
		if($this->Auth->user()) {
			$UserID = $this->Auth->user("id");
			$UserData = $this->Userdata->getUserDataById($UserID);
			
			if($UserData == false) {
				$this->redirect($this->Auth->logout());
				die;
			}
			
			self::$UserData = $UserData;
		}
		else {
			self::$UserData = false;
		}
		
		$this->set("userdata", self::$UserData);

		// CSRF (Cross-Site Request Forgery) Verification 
		if($this->Auth->user()) $userUniqueSecret = $this->Auth->user("username");
		else $userUniqueSecret = "29_291 unique xsrf secret";
		$this->csrf_token = sha1(microtime() . "unique_csrf_secret" . $userUniqueSecret);

		$this->set("csrf_token", $this->csrf_token);
	}

	function afterFilter() {
		// save csrf-token, etc.
		$this->Session->write("System.csrf_token", $this->csrf_token);
	}
}
