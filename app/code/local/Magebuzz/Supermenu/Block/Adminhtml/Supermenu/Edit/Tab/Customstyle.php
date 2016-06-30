<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Customstyle extends Mage_Adminhtml_Block_Widget_Form {
  protected function _prepareForm() {
    $form = new Varien_Data_Form();
    $this->setForm($form);    
    $fontType = Mage::getModel('supermenu/config_fonttype')->getOptionArray();

    $itemType = null;
    $itemTypeParam = $this->getRequest()->getParam('item_type');    
    if (isset($itemTypeParam) && $itemTypeParam != "") {
      $itemType = $itemTypeParam;
    } else {    
      if (Mage::registry('supermenu_data')) {
        $dataForm = Mage::registry('supermenu_data')->getData();
      } else {
        $id = $this->getRequest()->getParam('id');
        $dataForm = Mage::getModel('supermenu/supermenu')->load($id)->getData();
      }     
      $itemType = $dataForm['item_type'];
    }         

    if($itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_TEXT_LINK && $itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_CUSTOM ){     
      $fieldset = $form->addFieldset('supermenu_form', array('legend'=>Mage::helper('supermenu')->__('General Style')));

      $fieldset->addField('bg_box_color', 'text', array(
      'label'     => Mage::helper('supermenu')->__('Background Color for Box'),
      'class'     => 'required-entry color',    
      'name'      => 'bg_box_color', 
      'style'     => 'background-image: none; background-color: rgb(8, 230, 255); color: rgb(0, 0, 0);',
      'after_element_html'  => 'Click to select color'  
      ));

      $fieldset->addField('bg_boder_color', 'text', array(
      'label'     => Mage::helper('supermenu')->__('Border Color for Box'),
      'class'     => 'required-entry color',    
      'name'      => 'bg_boder_color',
      ));

      $fieldset->addField('border_size', 'text', array(
      'label'    => Mage::helper('supermenu')->__('Border Size'),    
      'required'  => false,
      'name'    => 'border_size',
      'after_element_html'  => 'Example : 2px'  
      ));
    }
    $fieldsetTitle = $form->addFieldset('supermenu_form_title', array('legend'=>Mage::helper('supermenu')->__('Styles for title')));

    $fieldsetTitle->addField('item_font_type', 'select', array(
	    'label'     => Mage::helper('supermenu')->__('Font Type'),  
	    'name'      => 'item_font_type',
	    'values'    =>  $fontType    
    ));

    $fieldsetTitle->addField('item_font_size', 'text', array(
	    'label'     => Mage::helper('supermenu')->__('Font Size'),        
	    'name'      => 'item_font_size',
	    'after_element_html'  => 'Example : 10px'
    ));

    $fieldsetTitle->addField('item_font_color', 'text', array(
	    'label'    => Mage::helper('supermenu')->__('Color'),    
	    'required'  => false,
	    'name'    => 'item_font_color',
	    'class'     => 'required-entry color',    
    ));

    $fieldsetTitle->addField('item_font_hover_color', 'text', array(
	    'label'    => Mage::helper('supermenu')->__('Hover Color'),    
	    'required'  => false,
	    'name'    => 'item_font_hover_color',
	    'class'     => 'required-entry color',    
    ));
		
    if ($itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_TEXT_LINK && $itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_CUSTOM ){     
      $fieldsetSubTitle = $form->addFieldset('supermenu_form_title_subitem', array('legend'=>Mage::helper('supermenu')->__('Styles for sub items')));

      $fieldsetSubTitle->addField('subitem_font_type', 'select', array(
      'label'     => Mage::helper('supermenu')->__('Font Type'),  
      'name'      => 'subitem_font_type',   
      'values'    =>  $fontType   
      ));

      $fieldsetSubTitle->addField('subitem_font_size', 'text', array(
      'label'     => Mage::helper('supermenu')->__('Font Size'),        
      'name'      => 'subitem_font_size',
      'after_element_html'  => 'Example : 10px'
      ));

      $fieldsetSubTitle->addField('subitem_font_color', 'text', array(
      'label'    => Mage::helper('supermenu')->__('Color'),    
      'required'  => false,
      'name'    => 'subitem_font_color',
      'class'     => 'required-entry color',    
      ));

      $fieldsetSubTitle->addField('subitem_font_hover_color', 'text', array(
      'label'    => Mage::helper('supermenu')->__('Hover Color'),    
      'required'  => false,
      'name'    => 'subitem_font_hover_color',
      'class'     => 'required-entry color',    
      ));
    }

    if (Mage::getSingleton('adminhtml/session')->getSupermenuData()) {
      $dataForm = Mage::getSingleton('adminhtml/session')->getSupermenuData();
      Mage::getSingleton('adminhtml/session')->getSupermenuData(null);
    } elseif ( Mage::registry('supermenu_data') ) {
      $dataForm = Mage::registry('supermenu_data')->getData();
    }
		
    if (isset($dataForm['icon_item']) && $dataForm['icon_item'] != '') {
      $dataForm['icon_item'] = 'supermenu/icon_image/' . $dataForm['icon_item'];
    }

    if (isset($dataForm['item_style']) && $dataForm['item_style'] !=null) {
      $itemStyle = $dataForm['item_style']->getData();
      $dataForm =  array_merge($dataForm , $itemStyle) ;     
    }
		
		
		// defaule color for Box content
		$defaultData = Mage::helper('supermenu')->defaultStyle();
		
    if ($itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_TEXT_LINK && $itemType != Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_CUSTOM ) {
      if (!isset($dataForm['bg_box_color']) || $dataForm['bg_box_color'] == '') {
        $dataForm['bg_box_color'] = $defaultData['bg_box_color'];
      }       

      // default color for Sub Title
      if (!isset($dataForm['subitem_font_color']) || $dataForm['subitem_font_color'] == '') {
        $dataForm['subitem_font_color'] = $defaultData['subitem_font_color'];  
      }
      if (!isset($dataForm['subitem_font_hover_color']) || $dataForm['subitem_font_hover_color'] == '') {
        $dataForm['subitem_font_hover_color'] =  $defaultData['subitem_font_hover_color'];
      }
      if (!isset($dataForm['subitem_font_type']) || $dataForm['subitem_font_type'] == '') {
        $dataForm['subitem_font_type'] =  $defaultData['subitem_font_type'];    
      }
      if (!isset($dataForm['subitem_font_size']) || $dataForm['subitem_font_size'] == '') {
        $dataForm['subitem_font_size'] =  $defaultData['subitem_font_size'];    
      }
    }

    // default color for font Title
    if (!isset($dataForm['item_font_color']) || $dataForm['item_font_color'] == '') {
      $dataForm['item_font_color'] = $defaultData['item_font_color'];   
    }
    if (!isset($dataForm['item_font_hover_color']) || $dataForm['item_font_hover_color'] == '') {
      $dataForm['item_font_hover_color'] =  $defaultData['item_font_hover_color'];    
    } 

    if (!isset($dataForm['item_font_type']) || $dataForm['item_font_type'] == '') {
      $dataForm['item_font_type'] =  $defaultData['item_font_type'];    
    }
    if (!isset($dataForm['item_font_size']) || $dataForm['item_font_size'] == '') {
      $dataForm['item_font_size'] =  $defaultData['item_font_size'];    
    }


    $form->setValues($dataForm);        
    return parent::_prepareForm();
  }
}