<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Sidebar extends Magebuzz_Supermenu_Block_Supermenu {
  public function _construct() {
	if (Mage::getStoreConfig('supermenu/general/sidebar_position')== 1) {
		$this->setTemplate('supermenu/sidebar/left.phtml');
	}
	if(Mage::getStoreConfig('supermenu/general/sidebar_position')== 2){
		$this->setTemplate('supermenu/sidebar/right.phtml');
	}
    return parent::_construct();
  }
}