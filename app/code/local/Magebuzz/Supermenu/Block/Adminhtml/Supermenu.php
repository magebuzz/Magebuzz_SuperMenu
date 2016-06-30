<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu extends Mage_Adminhtml_Block_Widget_Grid_Container {
  public function __construct() {
    $this->_controller = 'adminhtml_supermenu';
    $this->_blockGroup = 'supermenu';
    $this->_headerText = Mage::helper('supermenu')->__('Menu Manager');
    $this->_addButtonLabel = Mage::helper('supermenu')->__('Add Menu Item');
    parent::__construct();
  }
}