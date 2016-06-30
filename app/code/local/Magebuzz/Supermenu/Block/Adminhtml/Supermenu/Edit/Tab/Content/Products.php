<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content_products extends Mage_Adminhtml_Block_Template {

  public function __construct() {
    parent::__construct();
    $this->setTemplate('supermenu/create/edit/tab/products.phtml');    
  }

  public function render(Varien_Data_Form_Element_Abstract $element)
  {
    $this->_element = $element;
    return $this->toHtml();
  }

  public function productData(){
    $dataForm = Mage::getModel('supermenu/supermenu')->getData();
    if ( Mage::registry('supermenu_data') ) {
      $dataForm = Mage::registry('supermenu_data')->getData();
    }
    return $dataForm;
  }
  public function getTemplateList(){
    return Mage::helper('supermenu')->listTemplate();
  }
}