<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class AppModel extends Model {
	var $actsAs = array("Containable");
	var $recursive = -1;

	/*function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		$args = func_get_args();
		$uniqueCacheId = '';
		foreach($args as $arg) {
			$uniqueCacheId .= serialize($arg);
		}
		if(!empty($extra['contain'])) {
			$contain = $extra['contain'];
		}
		$uniqueCacheId = md5($uniqueCacheId);
		$pagination = Cache::read('pagination-'.$this->alias.'-'.$uniqueCacheId, 'medium');
		if(empty($pagination)) {
			$pagination = $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'group', 'contain'));
			Cache::write('pagination-'.$this->alias.'-'.$uniqueCacheId, $pagination, 'medium');
		}
		return $pagination;
	}

	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$args = func_get_args();
		$uniqueCacheId = '';
		foreach($args as $arg) {
			$uniqueCacheId .= serialize($arg);
		}
		$uniqueCacheId = md5($uniqueCacheId);
		if(!empty($extra['contain'])) {
			$contain = $extra['contain'];
		}

		$paginationcount = Cache::read('paginationcount-'.$this->alias.'-'.$uniqueCacheId, 'medium');
		if(empty($paginationcount)) {
			$paginationcount = $this->find('count', compact('conditions', 'contain'));
			Cache::write('paginationcount-'.$this->alias.'-'.$uniqueCacheId, $paginationcount, 'medium');
		}
		return $paginationcount;
	}*/
}
