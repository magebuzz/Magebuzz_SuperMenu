<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form {
  protected function _prepareLayout() {
    parent::_prepareLayout();
  }
  protected function _prepareForm() {
    $form = new Varien_Data_Form();
    $this->setForm($form);
    $type = "";
    $itemTypeParam = $this->getRequest()->getParam('item_type');
    if (isset($itemTypeParam) && $itemTypeParam !="") {
      $type = $itemTypeParam;
    } else {
      if ( Mage::registry('supermenu_data') ) {
        $dataForm = Mage::registry('supermenu_data')->getData();
      } else{
        $id = $this->getRequest()->getParam('id');
        $dataForm = Mage::getModel('supermenu/supermenu')->load($id)->getData();
      }
      $type = $dataForm['item_type'];

    }

    $fontType = Mage::getModel('supermenu/config_fonttype')->getOptionArray();

    // using wisiwyg from cms 
    $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
    $wysiwygConfig->setData(array(
      'add_variables'    => false,
      'plugins'      => array(),
      'widget_window_url'  => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
      'directives_url'  => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
      'directives_url_quoted'  => preg_quote(Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive')),
      'files_browser_window_url'  => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
    ));
    // add field Hearder Content 
    $fieldset = $form->addFieldset('supermenu_form_header_content', array('legend'=>Mage::helper('supermenu')->__('Header Content')));
    $fieldset->addField('header_content', 'editor',
      array(
        'label'     =>   Mage::helper('supermenu')->__('Header Content'),
        'title'     =>   Mage::helper('supermenu')->__('Header Content'),
        'name'      =>  'header_content',
        'wysiwyg'   => true,
        'style'     => 'width:600px;',
        'config'    =>  $wysiwygConfig
      )
    );
    // add field Content

    // add tab content for category
    if ($type == 2) {
      $renderer = Mage::getBlockSingleton('supermenu/adminhtml_supermenu_edit_tab_content_categories');
      $renderer->setTitleContent('Main Content');
      $renderer->setFieldCategory('categorys_content');
      $renderer->setHidenInputId('categorys_content');
      $fieldsetContent = $form->addFieldset('supermenu_form_content',
        array(
          'legend'=>Mage::helper('supermenu')->__('Content')
        )
      )->setRenderer($renderer);

      // add tab content for product 
    }else if($type==3){
      $renderProduct = Mage::getBlockSingleton('supermenu/adminhtml_supermenu_edit_tab_content_products');
      $productContents = $form->addFieldset('supermenu_form_product_content', array(
          'legend'=>Mage::helper('supermenu')->__('Content Product'))
      )->setRenderer($renderProduct);

      // add tab content for custom content
    }else if($type == 4){
      $customContentFieldset = $form->addFieldset('supermenu_form_custom_content', array('legend'=>Mage::helper('supermenu')->__('Custom Content')));
      $collectionBlock = Mage::getModel('cms/block')->getCollection()->getData();
      $blockArray = array();
      $defaultArray = array('value' => 0, 'label' => 'No Static Block');
      array_push($blockArray, $defaultArray);
      foreach($collectionBlock as $key => $value){
        $array = array('value' => $collectionBlock[$key]['block_id'], 'label' => $collectionBlock[$key]['title']);
        array_push($blockArray, $array);
      }
      $customContentFieldset->addField('featured_block', 'select', array(
        'name'      => 'featured_block',
        'label'     => Mage::helper('supermenu')->__('Custom Static Block'),
        'title'     => Mage::helper('supermenu')->__('Custom Static Block'),
        'required'  => false,
        'values'   => $blockArray,
      ));

      $customContentFieldset->addField('custom_content', 'editor', array(
        'label'     =>   Mage::helper('supermenu')->__('Custom Content'),
        'title'     =>   Mage::helper('supermenu')->__('Custom Content'),
        'name'      =>  'custom_content',
        'wysiwyg'   => true,
        'style'     => 'width:600px;',
        'config'    =>  $wysiwygConfig
      ));
      $customContentFieldset->addField('width_of_column', 'text', array(
        'label'     => Mage::helper('supermenu')->__('Maximum width of content'),
        'required'  => false,
        'name'      => 'width_of_column',
      ));
    }
    // feature content
    if($type != 4){
      $renderers = Mage::getBlockSingleton('supermenu/adminhtml_supermenu_edit_tab_content_feature');
      $renderers->setTitleContent('Main Content');
      $renderers->setFieldCategory('category_content');
      $featureContent = $form->addFieldset('supermenu_form_feature_content', array(
          'legend'=>Mage::helper('supermenu')->__('Featured Content'))
      )->setRenderer($renderers);

    }
    // add field Footer Content         
    $footerFieldset = $form->addFieldset('supermenu_form_footer_content', array('legend'=>Mage::helper('supermenu')->__('Footer Content')));
    $footerFieldset->addField('footer_content', 'editor', array(
        'label'     =>   Mage::helper('supermenu')->__('Footer Content'),
        'title'     =>   Mage::helper('supermenu')->__('Footer Content'),
        'name'      =>  'footer_content',
        'wysiwyg'   => true,
        'style'     => 'width:600px;',
        'config'    =>  $wysiwygConfig
      )
    );
    if (Mage::getSingleton('adminhtml/session')->getSupermenuData()) {
      $dataForm = Mage::getSingleton('adminhtml/session')->getSupermenuData();
      Mage::getSingleton('adminhtml/session')->getSupermenuData(null);
    } elseif ( Mage::registry('supermenu_data') ) {
      $dataForm = Mage::registry('supermenu_data')->getData();
    }
    $form->setValues($dataForm);
    return parent::_prepareForm();
  }


}
