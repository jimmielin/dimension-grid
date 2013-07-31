<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.976.45
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class Company_account extends AppModel {
	var $name = "Company_account";
	
	var $belongsTo = array(
		"Company",
		"Currency"
	);

	/**
	 * Transaction API. Basically, transfer money from a USER account to a COMPANY account.
	 */
	function transferFromUserToCompany($amount, $from, $to) {
		$FromAcc = $this->Currency->Account->find("first", array("conditions" => array("Account.id" => $from)));
		$ToAcc = $this->find("first", array("conditions" => array("Company_account.id" => $to)));

		if(!$FromAcc or !$ToAcc) return false;
		$NewFromAmount = floatval($FromAcc["Account"]["amount"]) - floatval($amount);
		$NewToAmount = floatval($ToAcc["Company_account"]["amount"]) + floatval($amount);

		if($NewFromAmount < 0 || $NewToAmount < 0) return false;
		
		$this->Currency->Account->id = $from;
		$this->Currency->Account->saveField("amount", $NewFromAmount);
		
		$this->id = $to;
		$this->saveField("amount", $NewToAmount);
		
		return true;
	}

	/**
	 * Transaction API. Basically, transfer money from a COMPANY account to a USER account.
	 */
	function transferFromCompanyToUser($amount, $from, $to) {
		$FromAcc = $this->find("first", array("conditions" => array("Company_account.id" => $from)));
		$ToAcc = $this->Currency->Account->find("first", array("conditions" => array("Account.id" => $to)));

		if(!$FromAcc or !$ToAcc) return false;
		$NewFromAmount = floatval($FromAcc["Company_account"]["amount"]) - floatval($amount);
		$NewToAmount = floatval($ToAcc["Account"]["amount"]) + floatval($amount);

		if($NewFromAmount < 0 || $NewToAmount < 0) return false;
		
		$this->id = $from;
		$this->saveField("amount", $NewFromAmount);
		
		$this->Currency->Account->id = $to;
		$this->Currency->Account->saveField("amount", $NewToAmount);
		
		return true;
	}

	/**
	 * Transaction API. Basically, transfer money from one account to the other. This is BETWEEN company accounts, USUALLY not used.
	 */
	function transferInternal($amount, $from, $to) {
		$FromAcc = $this->find("first", array("conditions" => array("Company_account.id" => $from)));
		$ToAcc = $this->find("first", array("conditions" => array("Company_account.id" => $to)));
		
		if(!$FromAcc or !$ToAcc) return false;
		$NewFromAmount = floatval($FromAcc["Company_account"]["amount"]) - floatval($amount);
		$NewToAmount = floatval($ToAcc["Company_account"]["amount"]) + floatval($amount);

		if($NewFromAmount < 0 || $NewToAmount < 0) return false;
		
		$this->id = $from;
		$this->saveField("amount", $NewFromAmount);
		
		$this->id = $to;
		$this->saveField("amount", $NewToAmount);
		
		return true;
	}
}
