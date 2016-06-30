<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Model_Config_Position extends Varien_Object {
	const TOP_MENU	    = 1;
  const SIDEBAR_MENU  = 2;
	const BOTH_MENU  = 3;

	static public function getOptionArray() {
		return array(
			self::TOP_MENU    => Mage::helper('supermenu')->__('Top Navigation'),
      self::SIDEBAR_MENU   => Mage::helper('supermenu')->__('Sidebar Navigation'),
			self::BOTH_MENU   => Mage::helper('supermenu')->__('Top & Sidebar Navigation')
		);
	}
}