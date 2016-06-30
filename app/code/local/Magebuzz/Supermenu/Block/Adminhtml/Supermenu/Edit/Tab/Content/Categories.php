<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content_Categories extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories 
implements Varien_Data_Form_Element_Renderer_Interface{

  public function __construct() {
    parent::__construct();
    $this->setTemplate('supermenu/create/edit/tab/categories.phtml');
  }

  protected function getCategoryIds() {
    $model = $this->getCategory(); 
    $fieldContent = $this->getFieldCategory();
    $stringCate = $model->getData($fieldContent);    
    $data = array();         
    return $data = explode(',',$stringCate);      
  }  

  public function isReadonly() {
    return false;
  }

  public function getIdsString() {
    $model = $this->getCategory();
    $fieldContent = $this->getFieldCategory();
    $stringCate = $model->getData($fieldContent); 
    return $stringCate ;
  }

  public function getCategory(){    
    return Mage::registry('supermenu_data'); 
  }
  public function render(Varien_Data_Form_Element_Abstract $element)
  {
    $this->_element = $element;
    return $this->toHtml();
  }
  public function categoryData(){
    $dataForm = Mage::getModel('supermenu/supermenu')->getData();
    if ( Mage::registry('supermenu_data') ) {
      $dataForm = Mage::registry('supermenu_data')->getData();
    }
    return $dataForm;
  }
}
