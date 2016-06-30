<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Supermenu extends Mage_Catalog_Block_Product_Abstract {
  public function _prepareLayout() {
    return parent::_prepareLayout();
  }

  public function getSupermenu() { 
    if (!$this->hasData('supermenu')) {
      $this->setData('supermenu', Mage::registry('supermenu'));
    }
    return $this->getData('supermenu');		
  }

  public function getSuperMenuItems() {
    $menuCollection = Mage::getModel('supermenu/supermenu')->getCollection();
    $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, Mage::app()->getStore()->getId());
    $menuCollection->getSelect()
    ->join(array('menu_store' => Mage::getModel('core/resource')->getTableName('supermenu_store')), 'main_table.supermenu_id = menu_store.supermenu_id')
    ->where('main_table.status=?', Magebuzz_Supermenu_Model_Status::STATUS_ENABLED)
    ->where('menu_store.store_id in (?)', $storeIds)
    ->group('main_table.supermenu_id')
    ->order('main_table.sort_order','ASC');
    return $menuCollection;      
  }  

  public function getMenuItemsByPosition($position) {
    if ($position) {
      $collection = $this->getSuperMenuItems();
      $position = array($position, Magebuzz_Supermenu_Model_Config_Position::BOTH_MENU);
      $collection->addFieldToFilter('position',array('in' => $position));      
      return $collection;
    }
    return false;
  }

  public function getHtmlContentItem($item) {    
    $itemType = $item->getItemType();     
    switch ($itemType){
      case Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_CATEGORY:    
        return $this->getCategoryHtml($item);
        break;
      case Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_PRODUCT:
        return $this->getProductHtml($item);
        break;  
      case Magebuzz_Supermenu_Model_Config_Itemtype::TYPE_CUSTOM:
        return $this->getCustomContentHtml($item);
        break;        
    }

  }

  public function getCategoryHtml($item) {
    $block = $this->getLayout()->createBlock('supermenu/items_categories');
    if($item->getTemplateId() == 2){
      $block->setTemplate('supermenu/items/category/tablist.phtml');
    } else{
      $block->setTemplate('supermenu/items/categories.phtml');
    }
    $block->setItemData($item);          
    return $block->toHtml();
  }

  public function getProductHtml($item) {
    $block = $this->getLayout()->createBlock('supermenu/items_product');
    if ($item->getTemplateId()== Magebuzz_Supermenu_Helper_Data::TEMPLATE_TEXT_IMAGE) {
      $block->setTemplate('supermenu/items/products/title_des.phtml');
    } else if($item->getTemplateId()== Magebuzz_Supermenu_Helper_Data::TEMPLATE_DESCRIPTION) {
        $block->setTemplate('supermenu/items/products/full_information.phtml');   
      }else {
        $block->setTemplate('supermenu/items/products/title_des.phtml');   
    }
    $block->setItemData($item);          
    return $block->toHtml();
  }

  public function getFeatureHtml($item) {
    $block = $this->getLayout()->createBlock('supermenu/supermenu');
    if ($item->getFeaturedType()== 'category') {
      $block->setTemplate('supermenu/items/feature/category.phtml');  
    } else if($item->getFeaturedType()== 'product') {
        $block->setTemplate('supermenu/items/feature/product.phtml');     
      }else{
        return null;
    }  
    $block->setItemData($item);
    return $block->toHtml();
  }

  public function getFeatureProducts($item) {    
    $productIds = explode(',',$item->getFeaturedProducts());
    $collection = null;
    if (!empty($productIds)) {    
      $collection = $this->getListProduct($productIds);      
    }
    return $collection;
  }             

  public function getListProduct($productIds) {
    $storeId = Mage::app()->getStore()->getId();    
    $collection = Mage::getResourceModel('catalog/product_collection');       
    $collection->addFieldToFilter('entity_id',array('in'=>$productIds));   
    $collection->setStoreId($storeId)
    ->addStoreFilter($storeId)
    ->addAttributeToSelect('*');
    return $collection;
  }

  public function getFeatureCategories($item) {    
    $categoryIds = explode(',', $item->getFeaturedCategorys());
    $collection = null;
    if (!empty($categoryIds)) {
      $collection = $this->getCategoryById($categoryIds);
    }
    return $collection;
  }

  public function getCategoryById($categoryIds) {
    $store = Mage::app()->getStore()->getId();  
    $categories = Mage::getResourceModel('catalog/category_collection');
    $categories->addAttributeToSelect('*')->addAttributeToFilter('entity_id', array('in'=>$categoryIds)) 
    ->addFieldToFilter('is_active', 1) ;    
    $categories->setStore($store);    
    return $categories; 
  }

  public function displayOnLeftSidebarBlock() {
    $block = $this->getParentBlock();
    if ($block) {
      if (Mage::helper('supermenu')->getSidebarNavigationType() == 1) {  
        $sidebarBlock = $this->getLayout()->createBlock('supermenu/sidebar');     
        $block->insert($sidebarBlock, '', false, 'supermenu-sidebar');
      }
    }
  }

  public function displayOnRightSidebarBlock() {
    $block = $this->getParentBlock();
    if ($block) {
      if (Mage::helper('supermenu')->getSidebarNavigationType() == 2) {
        $sidebarBlock = $this->getLayout()->createBlock('supermenu/sidebar');
        $block->insert($sidebarBlock, '', false, 'supermenu-sidebar');
      }
    }
  }

}