<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */
 
class DashboardController extends AppController {
	var $name = "Dashboard";
	var $uses = array("User");
	
	function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow("index");
	}
	
	function index() {
		// Get the events...
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
		$localEvents = $this->User->Citizenship->Event->find('all', array('conditions' => array('Event.country_id' => $userdata["Region"]["Country"]["id"]), 'contain' => 'Country', "limit" => 5, "order" => "Event.date DESC"));
		$allEvents = $this->User->Citizenship->Event->find('all', array('contain' => "Country", "limit" => 5, "order" => "Event.date DESC"));

		$this->set('localEvents', $localEvents);
		$this->set('allEvents', $allEvents);
	}

	function stats() {
		
	}

	function test() {
	}
}