<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content_Feature extends Mage_Adminhtml_Block_Template implements Varien_Data_Form_Element_Renderer_Interface{

  public function __construct() {
    parent::__construct();
    $this->setTemplate('supermenu/create/edit/tab/content/feature.phtml');    
  }

  public function getCategoryHtml(){
    $renderer = Mage::getBlockSingleton('supermenu/adminhtml_supermenu_edit_tab_content_categories')->setTemplate('supermenu/create/edit/tab/content/feature-categories.phtml');         
    $renderer->setFieldCategory('featured_categorys');
    $renderer->setHidenInputId('featured_categorys');
    return $renderer->toHtml();
  }   

  public function featuredData(){
    $dataForm = Mage::getModel('supermenu/supermenu')->getData();
    if ( Mage::registry('supermenu_data') ) {
      $dataForm = Mage::registry('supermenu_data')->getData();
    }
    return $dataForm;
  }

  public function render(Varien_Data_Form_Element_Abstract $element)
  {
    $this->_element = $element;
    return $this->toHtml();
  }
}
