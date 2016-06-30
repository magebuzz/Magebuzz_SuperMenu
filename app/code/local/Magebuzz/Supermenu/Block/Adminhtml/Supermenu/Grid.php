<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Block_Adminhtml_Supermenu_Grid extends Mage_Adminhtml_Block_Widget_Grid {
  public function __construct() {
    parent::__construct();
    $this->setId('supermenuGrid');
    $this->setDefaultSort('supermenu_id');
    $this->setDefaultDir('ASC');
    $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection() {
    $collection = Mage::getModel('supermenu/supermenu')->getCollection();
    $this->setCollection($collection);    
    return parent::_prepareCollection();
  }

  protected function _prepareColumns() {
    $this->addColumn('supermenu_id', array(
	    'header'    => Mage::helper('supermenu')->__('ID'),
	    'align'     =>'right',
	    'width'     => '50px',
	    'index'     => 'supermenu_id',
    ));

    $this->addColumn('text_item', array(
	    'header'    => Mage::helper('supermenu')->__('Title'),
	    'align'     =>'left',
	    'index'     => 'text_item',
    ));

    $listItemType = Mage::getModel('supermenu/config_itemtype')->getOptionArray();
    $this->addColumn('item_type', array(
	    'header'    => Mage::helper('supermenu')->__('Menu Type'),
	    'align'     => 'left',
	    'width'     => '150px',
	    'index'     => 'item_type',
	    'type'      => 'options',
	    'options'   => $listItemType
    ));

    $listPosition = Mage::getModel('supermenu/config_position')->getOptionArray();
    $this->addColumn('position', array(
	    'header'    => Mage::helper('supermenu')->__('Position'),
	    'align'     => 'left',
	    'width'     => '150px',
	    'index'     => 'position',
	    'type'      => 'options',
	    'options'   => $listPosition
    ));

    $this->addColumn('status', array(
	    'header'    => Mage::helper('supermenu')->__('Status'),
	    'align'     => 'left',
	    'width'     => '80px',
	    'index'     => 'status',
	    'type'      => 'options',
	    'options'   => array(
	    1 => 'Enabled',
	    2 => 'Disabled',
	    ),
    ));

    $this->addColumn('action',
	    array(
	    'header'    =>  Mage::helper('supermenu')->__('Action'),
	    'width'     => '100',
	    'type'      => 'action',
	    'getter'    => 'getId',
	    'actions'   => array(
		    array(
		    'caption'   => Mage::helper('supermenu')->__('Edit'),
		    'url'       => array('base'=> '*/*/edit'),
		    'field'     => 'id'
		    )
	    ),
	    'filter'    => false,
	    'sortable'  => false,
	    'index'     => 'stores',
	    'is_system' => true,
    ));

    return parent::_prepareColumns();
  }

  protected function _prepareMassaction() {
    $this->setMassactionIdField('supermenu_id');
    $this->getMassactionBlock()->setFormFieldName('supermenu');

    $this->getMassactionBlock()->addItem('delete', array(
    'label'    => Mage::helper('supermenu')->__('Delete'),
    'url'      => $this->getUrl('*/*/massDelete'),
    'confirm'  => Mage::helper('supermenu')->__('Are you sure?')
    ));

    $statuses = Mage::getSingleton('supermenu/status')->getOptionArray();
    $positions = Mage::getSingleton('supermenu/config_position')->getOptionArray();
    array_unshift($statuses, array('label'=>'', 'value'=>''));
    $this->getMassactionBlock()->addItem('status', array(
	    'label'=> Mage::helper('supermenu')->__('Change status'),
	    'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
	    'additional' => array(
		    'visibility' => array(
			    'name' => 'status',
			    'type' => 'select',
			    'class' => 'required-entry',
			    'label' => Mage::helper('supermenu')->__('Status'),
			    'values' => $statuses
		    )
	    )
    ));

    $this->getMassactionBlock()->addItem('position', array(
	    'label'=> Mage::helper('supermenu')->__('Change Position'),
	    'url'  => $this->getUrl('*/*/massChangePosition', array('_current'=>true)),
	    'additional' => array(
				'visibility' => array(
				    'name' => 'position',
				    'type' => 'select',
				    'class' => 'required-entry',
				    'label' => Mage::helper('supermenu')->__('Position'),
				    'values' => $positions
			    )
	    )
    ));
    return $this;
  }

  public function getRowUrl($row) {
    return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
}