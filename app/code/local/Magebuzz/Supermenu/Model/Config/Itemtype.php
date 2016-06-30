<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/

class Magebuzz_Supermenu_Model_Config_Itemtype extends Varien_Object {  
  const TYPE_TEXT_LINK  = 1;
  const TYPE_CATEGORY   = 2;
  const TYPE_PRODUCT    = 3;  
  const TYPE_CUSTOM     = 4;  

  static public function getOptionArray() {

    $arrayType = array(    
    self::TYPE_TEXT_LINK     => Mage::helper('supermenu')->__('Fixed Link'),
    self::TYPE_CATEGORY      => Mage::helper('supermenu')->__('Category Listing'),
    self::TYPE_PRODUCT       => Mage::helper('supermenu')->__('Product Listing'),
    self::TYPE_CUSTOM        => Mage::helper('supermenu')->__('Custom Content')
    ) ;

    return $arrayType;
  }
}