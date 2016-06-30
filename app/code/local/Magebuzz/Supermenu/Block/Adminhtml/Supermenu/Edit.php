<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
  public function __construct() {
    parent::__construct();						 
    $this->_objectId = 'id';
    $this->_blockGroup = 'supermenu';
    $this->_controller = 'adminhtml_supermenu';

    $this->_updateButton('save', 'label', Mage::helper('supermenu')->__('Save Item'));
    $this->_updateButton('delete', 'label', Mage::helper('supermenu')->__('Delete Item'));

    $this->_addButton('saveandcontinue', array(
    'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
    'onclick'   => 'saveAndContinueEdit()',
    'class'     => 'save',
    ), -100);

    $this->_formScripts[] = "
    function toggleEditor() {
    if (tinyMCE.getInstanceById('supermenu_content') == null) {
    tinyMCE.execCommand('mceAddControl', false, 'supermenu_content');
    } else {
    tinyMCE.execCommand('mceRemoveControl', false, 'supermenu_content');
    }
    }

    function saveAndContinueEdit(){
    editForm.submit($('edit_form').action+'back/edit/');
    }
    ";
  }

  public function getHeaderText() {
    if( Mage::registry('supermenu_data') && Mage::registry('supermenu_data')->getId() ) {
      return Mage::helper('supermenu')->__("Edit Menu '%s'", $this->htmlEscape(Mage::registry('supermenu_data')->getTextItem()));
    } else {
      return Mage::helper('supermenu')->__('Add Menu');
    }
  }
}