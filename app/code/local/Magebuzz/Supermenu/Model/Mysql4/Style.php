<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Model_Mysql4_Style extends Mage_Core_Model_Mysql4_Abstract {
  public function _construct() {        
    $this->_init('supermenu/style', 'style_id');
  }
}