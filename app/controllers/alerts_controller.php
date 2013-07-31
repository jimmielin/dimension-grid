<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.6
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class AlertsController extends AppController {
	var $name = 'Alerts';
	var $helpers = array("Decoda");
	
	function index() {
		// get the user id
		$UID = $this->Auth->user("id");
		
		if(($alertsCache = Cache::read("alerts_{$UID}")) === false) {
			$alertsCache = $this->Alert->find(
				"all",
				array(
					"contain" => false,
					"conditions" => array(
						array(
							"Alert.user_id" => $UID
						)
					)
				)
			);
			
			Cache::write("alerts_{$UID}", $alertsCache, "default");
		}
		
		$this->set("data", $alertsCache);

		// on read, update everything as read. make sure that we do have entries though...
		if($alertsCache != false) {
			$this->Alert->updateAll(
				array('Alert.read' => 1),
				array('Alert.user_id' => $UID)
			);

			if($this->Alert->getAffectedRows() > 0) {
				Cache::delete("alerts_{$UID}"); // manually flush the cache
				Cache::delete("profile_{$UID}"); // flush the usercache too; it's also used
			}
		}
	}
	

	function delete() {
		// which one are we deleting?
		$args = func_get_args();
		if(count($args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$ID = intval($args[0]);
		$UID = $this->Auth->user('id');

		// are we deleting an alert which pertains to us?
		$alert = $this->Alert->findById($ID);
		if(!$alert or $alert["Alert"]["user_id"] != $UID) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		// delete.
		$this->Alert->delete($ID);
		$this->flash(__("Alert deleted successfully!", true), "/alerts");

		if($this->Alert->getAffectedRows() > 0) {
			Cache::delete("alerts_{$UID}"); // manually flush the cache
			Cache::delete("profile_{$UID}"); // flush the usercache too; it's also used
		}
	}

	function deleteall() {
		$UID = $this->Auth->user("id");

		$this->Alert->deleteAll(array("Alert.user_id" => $UID));

		$this->flash(__("All alerts deleted successfully!", true), "/alerts");

		if($this->Alert->getAffectedRows() > 0) {
			Cache::delete("alerts_{$UID}"); // manually flush the cache
			Cache::delete("profile_{$UID}"); // flush the usercache too; it's also used
		}
	}
}