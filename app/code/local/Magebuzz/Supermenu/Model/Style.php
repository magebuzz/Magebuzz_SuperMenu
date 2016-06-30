<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Model_Style extends Mage_Core_Model_Abstract {
	public function _construct() {
		parent::_construct();
		$this->_init('supermenu/style');
	}
}