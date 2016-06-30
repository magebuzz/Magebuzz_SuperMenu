<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
  public function __construct() {
    parent::__construct();
    $this->setId('supermenu_tabs');
    $this->setDestElementId('edit_form');
    $this->setTitle(Mage::helper('supermenu')->__('General Information'));
  }

  protected function _beforeToHtml() {
    $itemTypeParam = $this->getRequest()->getParam('item_type');
    $itemType = "";
    if(isset($itemTypeParam) && $itemTypeParam !=""){
      $itemType = $itemTypeParam;
    }else{
      $id = $this->getRequest()->getParam('id');
      $itemModel = Mage::getModel('supermenu/supermenu')->load($id);
      $itemType = $itemModel->getItemType();
    }                      
    $this->addTab('form_section', array(
    'label'     => Mage::helper('supermenu')->__('General Information'),
    'title'     => Mage::helper('supermenu')->__('General Information'),
    'content'   => $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit_tab_form')->toHtml(),
    ));
    if($itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_TEXT_LINK){
      $this->addTab('form_content_section', array(
      'label'     => Mage::helper('supermenu')->__('Content Box'),
      'title'     => Mage::helper('supermenu')->__('Content Box'),
      'content'   => $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit_tab_content')->toHtml(),
      ));
    }
    $this->addTab('form_custom_style_section', array(
    'label'     => Mage::helper('supermenu')->__('Custom Styles'),
    'title'     => Mage::helper('supermenu')->__('Custom Styles'),
    'content'   => $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit_tab_customstyle')->toHtml(),
    ));
    return parent::_beforeToHtml();
  }
}