<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.3
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class AppHelper extends Helper {
	private $urlcache = array();

	function url($url = null, $full = false) {
		if(is_array($url)) {
			$havekey = false;
			$haveint = false;
			$keyafterint = false;

			$cacheparts = array();
			$otherparts = array();
			foreach($url as $key => $value) {
				if(is_int($key)) {
					$haveint = true;
					$otherparts[] = $value;
				}
				else {
					$havekey = true;
					if($haveint) {
						$keyafterint = true;
					}
					$cacheparts[$key] = $value;
				}
			}

			if(($havekey) && ($haveint) && (!$keyafterint)) {
				$id = serialize($cacheparts);

				if(isset($this->urlcache[$id])) {
					$url = $this->urlcache[$id];
				}
				else {
					$url = parent::url($cacheparts, $full).'/';
					$this->urlcache[$id] = $url;
				}

				foreach ($otherparts as $value) {
					$url .= $value.'/';
				}

				return $url;
			}
			else {
				return parent::url($url, $full);
			}
		}
		else {
			return parent::url($url, $full);
		}
	}
}