<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/

class Magebuzz_Supermenu_Model_Mysql4_Supermenu extends Mage_Core_Model_Mysql4_Abstract {
  public function _construct() {    
    // Note that the supermenu_id refers to the key field in your database table.
    $this->_init('supermenu/supermenu', 'supermenu_id');
  }

  protected function _afterSave(Mage_Core_Model_Abstract $object) {
    // add store to database
    $oldStores = $this->lookupStoreIds($object->getId());
    $newStores = (array)$object->getStores();
    if (empty($newStores)) {
      $newStores = (array)$object->getStoreId();  
    }
    $table  = $this->getTable('supermenu/supermenu_store');
    $insert = array_diff($newStores, $oldStores);
    $delete = array_diff($oldStores, $newStores);

    if ($delete) {
      $where = array(
      'supermenu_id = ?'     => (int) $object->getId(),
      'store_id IN (?)' => $delete
      );
      $this->_getWriteAdapter()->delete($table, $where);
    }

    if ($insert) {
      $data = array();
      foreach ($insert as $storeId) {
        $data[] = array(
        'supermenu_id'  => (int) $object->getId(),
        'store_id' => (int) $storeId
        );
      }
      $this->_getWriteAdapter()->insertMultiple($table, $data);
    }
    if($object->getFeaturedCategorys() != ""){
      $helper = Mage::helper('supermenu')->prepareCategory(explode(',',$object->getFeaturedCategorys()));
      $object->setFeaturedCategorys(implode(',',$helper));
    }
    // add style 
    $styleModel = Mage::getModel('supermenu/style');
    if($object->getId()){
      $styleId = null;
      $collection = $styleModel->getCollection()->addFieldToFilter('supermenu_id',$object->getId());
      if(count($collection->getData())>0){
        $styleId = $collection->getFirstItem()->getStyleId();      
      }      
      $styleModel->setData($object->getData());
      $styleModel->setStyleId($styleId);
      $styleModel->save();
    }

    return parent::_afterSave($object);
  }

  protected function _afterLoad(Mage_Core_Model_Abstract $object) {
    if ($object->getId()) {
      $stores = $this->lookupStoreIds($object->getId());
      $object->setData('store_id', $stores);
      // load style 
      $style = $this->loadStyle($object->getId());
      $object->setData("item_style",$style);    

    }
    return parent::_afterLoad($object);
  }

  public function lookupStoreIds($itemId) {
    $adapter = $this->_getReadAdapter();
    $select  = $adapter->select()
    ->from($this->getTable('supermenu/supermenu_store'), 'store_id')
    ->where('supermenu_id = ?',(int)$itemId);

    return $adapter->fetchCol($select);
  }

  public function loadStyle($itemId){
    $styleCollection = Mage::getModel('supermenu/style')->getCollection()->addFieldToFilter('supermenu_id',$itemId);
    $style = null;
    if(count($styleCollection->getData())>0){
      $style = $styleCollection->getFirstItem();
    }
    return $style;
  }
}