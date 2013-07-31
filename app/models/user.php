<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class User extends AppModel {
	var $name = "User";
	var $displayField = "username";
	
	var $belongsTo = array(
		"Citizenship" => array(
			"className" => "Country",
			"foreignKey" => "citizenship"
		),
		"Region",
		"Party",
		"Congress",
		"Employee_set"
	);
	
	var $hasMany = array(
		"Alert",
		"Account",
		"Owned_company" => array(
			"className" => "Company",
			"foreignKey" => "owner_id"
		),
		"Shout"
	);

	var $hasOne = array(
		"Inventory",
		"Newspaper"
	);

	/**
	 * A deduct-platinum API to remove platinum from a user (like, pay to a NPC, etc)
	 */
	function deductPlatinum($amount, $fromUID) {
		if($amount < 0) return false;
		$amount = floatval($amount);

		$fromAccount = $this->find('first', array("conditions" => array("User.id" => $fromUID)));
		if(!$fromAccount) return false;

		$newFromAccVal = $fromAccount["User"]["platinum"] - $amount;

		if($newFromAccVal < 0) return false;

		$this->id = $fromUID;
		$this->saveField("platinum", $newFromAccVal);

		Cache::delete("profile_$fromUID");

		return true;
	}

	/**
	 * A increase-platinum API to add platinum to a user (like, buy Platinum, revert changes, etc)
	 */
	function increasePlatinum($amount, $toUID) {
		if($amount < 0) return false;
		$amount = floatval($amount);

		$fromAccount = $this->find('first', array("conditions" => array("User.id" => $toUID)));
		if(!$fromAccount) return false;

		$newAccVal = $fromAccount["User"]["platinum"] + $amount;

		if($newAccVal < 0) return false;

		$this->id = $toUID;
		$this->saveField("platinum", $newAccVal);

		Cache::delete("profile_$toUID");

		return true;
	}


	/**
	 * A transaction API to transfer Platinum from an account to another.
	 * Note that negative values are not accepted.
	 */
	function transferPlatinum($amount, $fromUID, $toUID) {
		if($amount <= 0) return false;
		$amount = floatval($amount);

		$fromAccount = $this->find('first', array("conditions" => array("User.id" => $fromUID)));
		$toAccount = $this->find('first', array("conditions" => array("User.id" => $toUID)));

		if(!$fromAccount || !$toAccount) return false;

		$newFromAccVal = floatval($fromAccount["User"]["platinum"]) - $amount;
		$newToAccVal   = floatval($toAccount["User"]["platinum"]) + $amount;

		$this->id = $fromUID;
		$this->saveField("platinum", $newFromAccVal);

		$this->id = $toUID;
		$this->saveField("platinum", $newToAccVal);

		return true;
	}
}
