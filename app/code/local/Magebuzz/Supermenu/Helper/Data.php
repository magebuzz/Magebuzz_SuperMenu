<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Helper_Data extends Mage_Core_Helper_Abstract {
  const TEMPLATE_TEXT_IMAGE      = 1;
  const TEMPLATE_DESCRIPTION     = 2;

  public function prepareCategory($var) {

    if (is_array($var)) {
      $var = array_unique($var);
      $var = array_filter($var, array($this, 'removeEmptyItems'));
      $var = @implode(',', $var);
    }       
    return $var;
  }
  public function removeEmptyItems($var) {
    if(!empty($var)){
      return $var; 
    }
  }

  public function isActiveModule(){
    return Mage::getStoreConfig('supermenu/general/active');
  }

  public function defaultStyle(){  
    $arrayData = array(
    "bg_box_color"=>Mage::getStoreConfig('supermenu/style_setting/bg_box_color'),
    "bg_boder_color"=>Mage::getStoreConfig('supermenu/style_setting/bg_boder_color'),
    "border_size"=>Mage::getStoreConfig('supermenu/style_setting/border_size'),
    "item_font_type"=>Mage::getStoreConfig('supermenu/style_setting/item_font_type'),
    "item_font_size"=>Mage::getStoreConfig('supermenu/style_setting/item_font_size'),
    "item_font_color"=>Mage::getStoreConfig('supermenu/style_setting/item_font_color'),
    "item_font_hover_color"=>Mage::getStoreConfig('supermenu/style_setting/item_font_hover_color'),
    "subitem_font_type"=>Mage::getStoreConfig('supermenu/style_setting/subitem_font_type'),
    "subitem_font_size"=>Mage::getStoreConfig('supermenu/style_setting/subitem_font_size'),
    "subitem_font_color"=>Mage::getStoreConfig('supermenu/style_setting/subitem_font_color'),
    "subitem_font_hover_color"=>Mage::getStoreConfig('supermenu/style_setting/subitem_font_hover_color'),
    );    
    return $arrayData; 
  }

  public function listTemplate(){
    return array(self::TEMPLATE_TEXT_IMAGE => 'Only Product Name',self::TEMPLATE_DESCRIPTION => 'Full Information') ;
  }
  
  public function categoryTemplate(){
    return array(self::TEMPLATE_TEXT_IMAGE => 'Normally',self::TEMPLATE_DESCRIPTION => 'Tab List') ;
  }

  public function getStyleByItemId($itemId){
    $item = Mage::getModel('supermenu/supermenu')->load($itemId);
    $style = $item->getItemStyle();
    return $style;
  }
	
	public function getStyleCss($itemId){
		$stylesArr = array();
		$styles = '';
		$itemStyles = $this->getStyleByItemId($itemId);
		if($itemStyles){
			$stylesArr[] = 'font-family:' . $itemStyles->getItemFontType();
			$stylesArr[] = 'font-size:' . $itemStyles->getItemFontSize();
			$stylesArr[] = 'color:#' . $itemStyles->getItemFontColor();
		}else{
			$stylesArr[] = 'font-family:' . Mage::getStoreConfig('supermenu/style_setting/item_font_type');
			$stylesArr[] = 'font-size:' . Mage::getStoreConfig('supermenu/style_setting/item_font_size');
			$stylesArr[] = 'color:#' . Mage::getStoreConfig('supermenu/style_setting/item_font_color');
		}	
			$styles = implode(';', $stylesArr);
		return $styles;
	}
	
	public function getSubitemsCss($itemId){
		$stylesArr = array();
		$styles = '';
		$itemStyles = $this->getStyleByItemId($itemId);
		if($itemStyles){
			$stylesArr[] = 'background:#' . $itemStyles->getBgBoxColor();
			$stylesArr[] = 'border:'.$itemStyles->getBorderSize().' solid #'. $itemStyles->getBgBoderColor();
			$stylesArr[] = 'font-family:' . $itemStyles->getSubitemFontType();
			$stylesArr[] = 'font-size:' . $itemStyles->getSubitemFontSize();
			$stylesArr[] = 'color:#' . $itemStyles->getSubitemFontColor();
		}else{
			$stylesArr[] = 'background:#' . Mage::getStoreConfig('supermenu/style_setting/bg_box_color');
			$stylesArr[] = 'border:'.Mage::getStoreConfig('supermenu/style_setting/border_size').' solid #'. Mage::getStoreConfig('supermenu/style_setting/bg_boder_color');
			$stylesArr[] = 'font-family:' . Mage::getStoreConfig('supermenu/style_setting/subitem_font_type');
			$stylesArr[] = 'font-size:' . Mage::getStoreConfig('supermenu/style_setting/subitem_font_size');
			$stylesArr[] = 'color:#' . Mage::getStoreConfig('supermenu/style_setting/subitem_font_color');
		}	
		$styles = implode(';', $stylesArr);
		return $styles;
	}
	
  
  public function getLinkbyItem($item){
    $link = $item->getLinkItem() ;    
    if($link !=""){
      if(preg_match("/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/", $link)){
        return $link;
      }else{
        return Mage::getUrl($link);
      }
    }
    return;
  } 
	
	public function displaySidebarNavigation() {
		$storeId = Mage::app()->getStore()->getId();
		return (bool) Mage::getStoreConfig('supermenu/general/sidebar_menu_active', $storeId);
	}
	
	public function getSidebarNavigationType() {
		if (!$this->displaySidebarNavigation()) {
			return 0;
		}
		$storeId = Mage::app()->getStore()->getId();
		return (int) Mage::getStoreConfig('supermenu/general/sidebar_position', $storeId);		
	}
}