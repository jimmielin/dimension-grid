<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.700.2
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

/**
 * This is a class for time management functions in the Grid.
 * It includes functions to manipulate times of the users, clear all time entries (done each 24 hours to reset the usedhours counter), etc.
 */
class TimemanagementComponent extends Object {
	var $components = array("Userdata");
	/**
	 * Constructor, and initializes some global vars
	 */
	function initialize() {
		$this->User = ClassRegistry::init("User");
		$this->GridDay = floor((time() - 1283299200)/60/60/24);

		$this->resetAll();
	}

	/**
	 * Global Time Management Functions.
	 * This includes routines that should be ran every 24 hours to reset the usedhours counter globally, and other user-based crons.
	 * Note that resetAll will be called on every construct, and it will auto-magically reset the time_spent counter if the gridday elapses.
	 * The last gridday update is stored in the cache value last_cron_reset_day, which is used globally across all time-based events in the Grid. The reset period for that cache value is 2419200, equivalent to 28 days (in seconds), in order to make sure it does not expire. Since it is ran every 86400 seconds (1 day), it should not be worried at all.
	 */
	function resetAll() {
		// The daily counter reset!
		$this->LastGridDayUpdate = file_get_contents(ROOT.DS."last_grid_cron_exec.txt");

		if($this->GridDay > $this->LastGridDayUpdate) {
			// update, expired.
			$this->User->updateAll(array("User.time_spent" => "0", "User.task_worked" => "0", "User.task_trained" => "0", "User.task_studied" => "0"));
			file_put_contents(ROOT.DS."last_grid_cron_exec.txt", $this->GridDay);
		}

		

	}

	/**
	 * Time Management Functions.
	 */
	function addCounter($uid, $hours = 0) {
		$this->User->id = $uid;
		$this->User->saveField("time_spent", $this->getUsedHours($uid) + $hours);

		Cache::delete("profile_$uid");
	}

	function performTask($uid, $task, $hours = 0) {
		$this->User->id = $uid;
		$hoursAvailable = 24 - $this->getUsedHours($uid);

		if($hoursAvailable < $hours) return false;

		switch($task) {
			case 'work':
				$this->User->saveField("task_worked", $hours);
			break;

			case 'study':
				$this->User->saveField("task_studied", $hours);
			break;

			case 'train':
				$this->User->saveField("task_trained", $hours);
			break;
		}

		$this->addCounter($uid, $hours);
		
		return true;
	}
	
	function recordTaskResults($uid, $data, $task) {
		$this->User->id = $uid;
		
		switch($task) {
			case 'work':
				$this->User->saveField("work_result_data", serialize($data));
			break;

			case 'study':
				$this->User->saveField("study_result_data", serialize($data));
			break;

			case 'train':
				$this->User->saveField("train_result_data", serialize($data));
			break;
		}

		Cache::delete("profile_$uid");
		
		return true;
	}

	function getUsedHours($uid) {
		$userdata = $this->Userdata->getUserDataById($uid);
		return $userdata["User"]["time_spent"];
	}
}