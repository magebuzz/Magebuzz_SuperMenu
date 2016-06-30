<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('supermenu')};
CREATE TABLE {$this->getTable('supermenu')} (
  `supermenu_id` int(11) unsigned NOT NULL auto_increment,
  `text_item` varchar(255) NOT NULL default '',
  `link_item` varchar(255) NOT NULL default '',
  `icon_item` varchar(255) NOT NULL default '',
  `short_description` text NOT NULL default '',
  `header_content` text NOT NULL default '',
  `footer_content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `sort_order` smallint(6) NOT NULL default '0',
  `item_type` smallint(6) NOT NULL default '0',
  `position` int(11) NOT NULL default '0',
  `template_id` int(11) NOT NULL default '0',
  
  `featured_type` varchar(255) NOT NULL default 'none',
  `featured_categorys` text NOT NULL default '',
  `featured_products` text NOT NULL default '',
  `featured_title` varchar(255) NOT NULL default '',
  `categorys_content` text NOT NULL default '',
  `products_content` text NOT NULL default '',
  `number_of_column` int(11) NOT NULL default '0',
  `width_of_column` int(11) NOT NULL default '0',
  `custom_content` text NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`supermenu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 -- DROP TABLE IF EXISTS {$this->getTable('supermenu_store')};
  CREATE TABLE {$this->getTable('supermenu_store')} (
    `supermenu_id` int(11) unsigned NOT NULL,
    `store_id` int(11) unsigned NOT NULL,
    PRIMARY KEY (`supermenu_id`, `store_id`),   
    CONSTRAINT `FK_MB_SUPERMENU_STORE_ITEM` FOREIGN KEY (`supermenu_id`) REFERENCES `{$this->getTable('supermenu')}` (`supermenu_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `FK_MB_SUPERMENU_STORE_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}` (`store_id`) ON UPDATE CASCADE ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
-- DROP TABLE IF EXISTS {$this->getTable('supermenu_style')};
CREATE TABLE {$this->getTable('supermenu_style')} (
  `style_id` int(11) unsigned NOT NULL auto_increment,
  `supermenu_id` int(11) unsigned NOT NULL default '0', 
  `bg_box_color` varchar(255) NOT NULL default '',
  `bg_boder_color` varchar(255) NOT NULL default '',
  `border_size` varchar(255) NOT NULL default '',
  `item_font_type` varchar(255) NOT NULL default '',
  `item_font_size` varchar(255) NOT NULL default '',
  `item_font_color` varchar(255) NOT NULL default '',
  `item_font_hover_color` varchar(255) NOT NULL default '',
  `subitem_font_type` varchar(255) NOT NULL default '',
  `subitem_font_size` varchar(255) NOT NULL default '',
  `subitem_font_color` varchar(255) NOT NULL default '',
  `subitem_font_hover_color` varchar(255) NOT NULL default '',
  PRIMARY KEY (`style_id`),
  CONSTRAINT `FK_MB_SUPERMENU_STYLE_ITEM` FOREIGN KEY (`supermenu_id`) REFERENCES `{$this->getTable('supermenu')}` (`supermenu_id`) ON UPDATE CASCADE ON DELETE CASCADE    
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;   
");

$installer->endSetup(); 