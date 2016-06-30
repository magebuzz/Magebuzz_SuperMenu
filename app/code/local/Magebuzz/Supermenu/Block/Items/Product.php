<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Items_Product extends Mage_Catalog_Block_Product_Abstract {

  protected $_items = null; 
  public function _prepareLayout() {
    return parent::_prepareLayout();
  }

  public function setItems($item){
    $this->_items = $item;
    return this;
  }

  public function getItems(){
    if (is_null($this->_items)) {
      $this->_items = $this->getItemData();
    }
    return $this->_items;
  }

  public function getListProduct($productIds){
    $collection = Mage::getResourceModel('catalog/product_collection');       
    $store_id = Mage::app()->getStore()->getId();
    $collection->addFieldToFilter('entity_id',array('in'=>$productIds));

    $collection->setStoreId($storeId)
    ->addStoreFilter($store_id)
    ->addAttributeToSelect('*');  
    return $collection;
  }
  public function getListCurrentProducts(){
    $item = $this->getItems();
    $productIds = explode(',',$item->getProductsContent());
    $collection = $this->getListProduct($productIds);
    return $collection;
  }

}