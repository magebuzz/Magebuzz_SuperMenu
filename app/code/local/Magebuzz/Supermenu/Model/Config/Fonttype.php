<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Model_Config_Fonttype extends Varien_Object {
  const ARIAL	    = 'Arial,Helmet,Freesans,sans-serif';
  const TIMES_NEW_ROMAN  = 'Times New Roman';
  const TAHOMA  = 'Tahoma, Geneva, sans-serif';
  const VERDANA  = 'Verdana, Geneva, sans-serif';
  const GEORGIA  = 'Georgia, serif';
  const BOOKMAN_OLD_STYLE  = 'Bookman Old Style, serif';
  const COMIC_SANS_MS  = 'Comic Sans MS, cursive';
  const COURIER_NEW  = 'Courier New, Courier, monospace';
  const GARAMOND  = 'Garamond, serif';
  const IMPACT  = 'Impact, Charcoal, sans-serif';
  const LUCIDA_CONSOLE  = 'Lucida Console, Monaco, monospace';
  const WEBDINGS  = 'Webdings, sans-serif';

  static public function getOptionArray() {

    return array(    
    self::ARIAL => 'Arial',        
    self::TIMES_NEW_ROMAN => 'Times New Roman',
    self::TAHOMA => 'Tahoma',
    self::VERDANA => 'Verdana',
    self::GEORGIA => 'Georgia',
    self::BOOKMAN_OLD_STYLE => 'Bookman Old Style',
    self::COMIC_SANS_MS => 'Comic Sans MS',
    self::COURIER_NEW => 'Courier New',
    self::GARAMOND => 'Garamond',
    self::IMPACT => 'Impact, Charcoal',
    self::LUCIDA_CONSOLE => 'Lucida Console, Monaco',
    self::WEBDINGS => 'Webdings',
    );    
  }
  public function toOptionArray()
  {
    return array(    
    self::ARIAL => 'Arial',        
    self::TIMES_NEW_ROMAN => 'Times New Roman',
    self::TAHOMA => 'Tahoma',
    self::VERDANA => 'Verdana',
    self::GEORGIA => 'Georgia',
    self::BOOKMAN_OLD_STYLE => 'Bookman Old Style',
    self::COMIC_SANS_MS => 'Comic Sans MS',
    self::COURIER_NEW => 'Courier New',
    self::GARAMOND => 'Garamond',
    self::IMPACT => 'Impact, Charcoal',
    self::LUCIDA_CONSOLE => 'Lucida Console, Monaco',
    self::WEBDINGS => 'Webdings',
    );    
  }
}