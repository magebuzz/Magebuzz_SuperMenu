<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Items_Categories extends Mage_Core_Block_Template {

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


  public function getCategories(){
    $itemData = $this->getItemData();
    $store = Mage::app()->getStore()->getId();
    $categoryidsTxt = $itemData->getCategorysContent();
    $categoryIds = explode(',',$categoryidsTxt);  
    $categories = $this->getCategoryById($categoryIds);
    return $categories;
  }
	
  public function getParentCategories(){
    $allCategory = $this->getCategories() ;
    $categoryIds = $allCategory->getAllIds();
    foreach($allCategory as $category){
      $parents = $category->getParentIds();
      if(count(array_intersect($parents, $categoryIds))== 0)
        $parentIds[] = $category->getId();
    }    
    $parentData = $this->getCategoryById($parentIds);    
    return $parentData;   
  }

  public function getSubByParent($category){    
    $arrayChildren = explode(',',$category->getChildren());
    $item = $this->getItems();
    $subCategoryIds = array();
    $subCategory = null;
    $categoryidsTxt = $item->getCategorysContent();
    $categoryIds = explode(',',$categoryidsTxt);  
    $subCategoryIds = array_intersect($arrayChildren, $categoryIds);
    if(count($subCategoryIds)>0){
      $subCategory = $this->getCategoryById($subCategoryIds);
    }    
    return $subCategory;
  }

  public function getCategoryById($categoryIds){
    $store = Mage::app()->getStore()->getId();  
    $categories = Mage::getResourceModel('catalog/category_collection');
    $categories->addAttributeToSelect('*')
			->addAttributeToFilter('entity_id', array('in'=>$categoryIds)) 
			->addFieldToFilter('is_active', 1)
			->addAttributeToSort('position');    
    $categories->setStore($store);    
    return $categories; 
  }

  public function getSubHtml($category,$col) {
    $subCategory = $this->getSubByParent($category) ;   
    $i = 0;
		$html = '';
    if(count($subCategory)> 0){  
      $html .='<ul class="subitems level'.$category->getLevel().'">';
      foreach($subCategory as $sub){  
        $i++;
        $html .= '<li class="level'.$sub->getLevel().' nav-'.$col.'-'.$i.'" >';    
        $html .='<a title="'.$sub->getName().'" href="'.$sub->getUrl().'" class="itemMenuName level'.$sub->getLevel().'">'.$sub->getName().'</a> ';            
        if($sub->getChildren()!=""){          
          $html .= $this->getSubHtml($sub,$col);          
        }
      }
      $html .='</ul>';
    }         

    return $html;
  }
}