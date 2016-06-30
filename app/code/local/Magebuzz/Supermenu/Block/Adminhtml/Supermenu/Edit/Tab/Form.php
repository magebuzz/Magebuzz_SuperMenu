<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
  protected function _prepareForm() {
    $form = new Varien_Data_Form();
    $this->setForm($form);
    $fieldset = $form->addFieldset('supermenu_form', array('legend'=>Mage::helper('supermenu')->__('General information')));   

    $fieldset->addField('item_type', 'hidden', array(
    'name'      => 'item_type',
    ));   

    $fieldset->addField('position', 'hidden', array(
    'name'      => 'position',
    ));  

    $fieldset->addField('text_item', 'text', array(
    'label'     => Mage::helper('supermenu')->__('Text Item'),
    'class'     => 'required-entry',
    'required'  => true,
    'name'      => 'text_item',
    ));

    $fieldset->addField('link_item', 'text', array(
    'label'    => Mage::helper('supermenu')->__('Link'),    
    'required'  => false,
    'name'    => 'link_item',
    ));

    $fieldset->addField('icon_item', 'image', array(
    'label'     => Mage::helper('supermenu')->__('Image Icon'),
    'required'  => false,      
    'name'      => 'icon_item',
    ));  

    $fieldset->addField('short_description', 'textarea', array(
    'label'     => Mage::helper('supermenu')->__('Short Description'),
    'required'  => false,      
    'name'      => 'short_description',    
    )); 
    
    if (!Mage::app()->isSingleStoreMode()) {
      $fieldset->addField('store_id', 'multiselect', array(
        'name'      => 'stores[]',
        'label'     => Mage::helper('supermenu')->__('Store View'),
        'title'     => Mage::helper('supermenu')->__('Store View'),
        'required'  => true,
        'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
      ));
    }
    else {
      $fieldset->addField('store_id', 'hidden', array(
        'name'      => 'stores[]',
        'value'     => Mage::app()->getStore(true)->getId()
      ));      
    }

    $fieldset->addField('status', 'select', array(
    'label'     => Mage::helper('supermenu')->__('Status'),
    'name'      => 'status',
    'values'    => array(
    array(
    'value'     => 1,
    'label'     => Mage::helper('supermenu')->__('Enabled'),
    ),
    array(
    'value'     => 2,
    'label'     => Mage::helper('supermenu')->__('Disabled'),
    ),
    ),
    ));  

    $fieldset->addField('sort_order', 'text', array(
    'label'    => Mage::helper('supermenu')->__('Sort Order'),
    'name'    => 'sort_order'
    ));                      

    if (Mage::getSingleton('adminhtml/session')->getSupermenuData()) {
      $dataForm = Mage::getSingleton('adminhtml/session')->getSupermenuData();
      Mage::getSingleton('adminhtml/session')->getSupermenuData(null);
    } elseif ( Mage::registry('supermenu_data') ) {
      $dataForm = Mage::registry('supermenu_data')->getData();
    }
    if (isset($dataForm['icon_item']) && $dataForm['icon_item'] != '') {
      $dataForm['icon_item'] = 'supermenu/items/' . $dataForm['icon_item'];
    }
    $param = $this->getRequest()->getParams();
    if(isset($param['item_type']) &&  isset($param['position']) && $param['item_type'] !="" && $param['position']!=""){
      $dataForm['item_type'] = $param['item_type'];
      $dataForm['position'] = $param['position'];      
    }        
    $form->setValues($dataForm);        
    return parent::_prepareForm();
  }


}