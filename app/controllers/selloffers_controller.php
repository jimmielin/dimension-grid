<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.976.13828
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class SellOffersController extends AppController {
	var $name = "SellOffers";

	function index() {
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

		$this->paginate = array(
			'conditions' => array(
				"SellOffer.country_id" => $userdata["Citizenship"]["id"],
			),
			"limit" => 50,
			"order" => "SellOffer.price_per_unit DESC"
		);

		$Data = $this->paginate("SellOffer");
		$this->set("data", $Data);
	}
}