<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.7
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Account extends AppModel {
	var $name = "Account";
	
	var $belongsTo = array(
		"Currency",
		"User"
	);

	/**
	 * Transaction API. Basically, transfer money from one account to the other.
	 */
	function transfer($amount, $from, $to) {
		$FromAcc = $this->find("first", array("conditions" => array("Account.id" => $from)));
		$ToAcc = $this->find("first", array("conditions" => array("Account.id" => $to)));
		
		if(!$FromAcc or !$ToAcc) return false;
		$NewFromAmount = floatval($FromAcc["Account"]["amount"]) - floatval($amount);
		$NewToAmount = floatval($ToAcc["Account"]["amount"]) + floatval($amount);

		if($NewFromAmount < 0 || $NewToAmount < 0) return false;
		
		$this->id = $from;
		$this->saveField("amount", $NewFromAmount);
		
		$this->id = $to;
		$this->saveField("amount", $NewToAmount);
		
		return true;
	}
}
