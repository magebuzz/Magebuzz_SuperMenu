<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Edit_Tab_Content_Featured_Renderer_Sku extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

  public function render(Varien_Object $row) 
  {
    $checked = '';
    if(in_array($row->getId(), $this->_getSelectedProducts()))
      $checked = 'checked';
    $html = '<input type="checkbox" '.$checked.' name="" value="'.$row->getId().'" class="checkbox" onclick="selectFeaturedProduct(this)">';
    return sprintf('%s', $html);
  }

  protected function _getSelectedProducts()
  {
    $products = $this->getRequest()->getPost('selected', array());
    return $products;
  }
}

