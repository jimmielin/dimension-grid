<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class UserdataComponent extends Object {
	function getUserDataById($UserID) {
		$UserModel = ClassRegistry::init("User");
		
		$UserID = intval($UserID);
		if(($UserData = Cache::read("profile_{$UserID}")) === false) {
			$UserData = $UserModel->find(
				"first",
				array(
					"conditions" => array(
						"User.id" => $UserID
					),
					"contain" => array(
						"Citizenship",
						"Region" => array(
							"Country"
						),
						"Party",
						"Alert" => array(
							"conditions" => array("Alert.read" => "0")
						),
						"Account.Currency",
						"Inventory",
						"Employee_set.Company",
						"Newspaper.Newspaper_article",
						"Owned_company",
						"Shout" => array(
							"order" => "Shout.date DESC",
							"limit" => 5
						)
					)
				)
			);
			if(!$UserData) return false;
			
			Cache::write("profile_{$UserID}", $UserData, "tiny");
		}
		
		return $UserData;
	}
}
