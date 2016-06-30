<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Model_Status extends Varien_Object {
	const STATUS_ENABLED	= 1;
	const STATUS_DISABLED	= 2;

	static public function getOptionArray() {
		return array(
			self::STATUS_ENABLED    => Mage::helper('supermenu')->__('Enabled'),
			self::STATUS_DISABLED   => Mage::helper('supermenu')->__('Disabled')
		);
	}
}