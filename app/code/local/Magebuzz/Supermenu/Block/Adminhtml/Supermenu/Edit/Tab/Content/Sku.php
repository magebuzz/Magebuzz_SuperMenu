<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/

class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content_Sku extends Mage_Adminhtml_Block_Widget_Grid
{

  public function __construct($arguments=array())
  {   
    parent::__construct($arguments);
    if ($this->getRequest()->getParam('product_grid_id')) {
      $this->setId($this->getRequest()->getParam('product_grid_id'));
    } else {
      $this->setId('skuChooserGrid_'.$this->getId());
    }

    $form = $this->getJsFormObject();
    $gridId = $this->getId();
    $this->setCheckboxCheckCallback("constructCurrentData($gridId)"); 
    $this->setDefaultSort('sku');
    $this->setUseAjax(true);
    if ($this->getRequest()->getParam('collapse')) {
      $this->setIsCollapsed(true);
    }
  }

  public function getStore()
  {
    return Mage::app()->getStore();
  }


  protected function _prepareCollection()
  {  
    $collection = Mage::getResourceModel('catalog/product_collection')
    ->setStoreId(0)
    ->addAttributeToSelect('name', 'type_id', 'attribute_set_id');

    $this->setCollection($collection);

    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {


    $this->addColumn('in_products', array(
    'header_css_class' => 'a-center',
    'type' => 'checkbox',
    'name' => 'in_products',
    'values' => $this->_getSelectedProducts(),
    'align' => 'center',
    'index' => 'sku',
    'use_index' => true,
    'class' =>'main_product' ,
    'renderer'  => 'Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content_Renderer_Sku' 
    ));

    $this->addColumn('entity_id', array(
    'header'    => Mage::helper('sales')->__('ID'),
    'sortable'  => true,
    'width'     => '60px',
    'index'     => 'entity_id'
    ));

    $this->addColumn('chooser_name', array(
    'header'    =>  Mage::helper('sales')->__('Product Name'),
    'name'      =>  'chooser_name',
    'index'     =>  'name',
    'width'     =>  '400px'
    ));

    $this->addColumn('type',
    array(
    'header'=> Mage::helper('catalog')->__('Type'),
    'width' => '60px',
    'index' => 'type_id',
    'type'  => 'options',
    'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
    ));

    $this->addColumn('chooser_sku', array(
    'header'    => Mage::helper('sales')->__('SKU'),
    'name'      => 'chooser_sku',
    'width'     => '80px',
    'index'     => 'sku',
    ));


    return parent::_prepareColumns();
  }

  public function getGridUrl()
  {

    return $this->getUrl('*/*/chooserCurentProducts', array(
    '_current'          => true,
    'product_grid_id'   => $this->getId(),
    'collapse'          => null
    ));
  }

  protected function _getSelectedProducts()
  {
    $products = $this->getRequest()->getPost('selected', array());  
    return $products;
  }

}

