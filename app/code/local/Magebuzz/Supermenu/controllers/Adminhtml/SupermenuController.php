<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/
class Magebuzz_Supermenu_Adminhtml_SupermenuController extends Mage_Adminhtml_Controller_Action {
  protected function _initAction() {
    $this->loadLayout()
    ->_setActiveMenu('supermenu/items')
    ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

    return $this;
  }   

  public function indexAction() {
    $this->_initAction()
    ->renderLayout();
  }

  public function editAction() {
    $id     = $this->getRequest()->getParam('id');
    $model  = Mage::getModel('supermenu/supermenu')->load($id);

    if ($model->getId() || $id == 0) {
      $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
      if (!empty($data)) {
        $model->setData($data);
      }      
      Mage::register('supermenu_data', $model);
      $this->loadLayout();
      $this->_setActiveMenu('supermenu/items');

      $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
      $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

      $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

      $this->_addContent($this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit'))
      ->_addLeft($this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit_tabs'));

      $this->renderLayout();
    } else {
      Mage::getSingleton('adminhtml/session')->addError(Mage::helper('supermenu')->__('Item does not exist'));
      $this->_redirect('*/*/');
    }
  }

  public function newAction() {
    $itemType = $this->getRequest()->getParam('item_type');
    if($itemType){
      $this->_forward('edit'); 
    }else{
      $this->loadLayout()
      ->_setActiveMenu('supermenu/items')
      ->_addBreadcrumb(Mage::helper('supermenu')->__('Create New Item Menu'), Mage::helper('supermenu')->__('Create New Item Menu'));
      $this->getLayout()->getBlock('head')->setTitle('Create New Item Menu');
      $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
      $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
      $this->renderLayout();
    }
  }
  public function submittypeAction() {
    $itemType = $this->getRequest()->getPost('item_type');
    $position = $this->getRequest()->getPost('position');
    if($itemType){
      $this->_redirect('*/*/new',array('item_type'=>$itemType,'position'=>$position)); 
    }else{
      $this->_redirect('*/*/');
    }
  }



  public function saveAction() {
    if ($data = $this->getRequest()->getPost()) {   
      $model = Mage::getModel('supermenu/supermenu');     
      $paramId = $this->getRequest()->getParam('id');
      if(isset($paramId) && $paramId !=''){
        $model->load($paramId);        
      }
      // upload and save Icons
      if(isset($_FILES['icon_item']['name']) && $_FILES['icon_item']['name'] != '') {        
        try {	
          /* Starting upload */	
          $uploader = new Varien_File_Uploader('icon_item');        
          $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
          $uploader->setAllowRenameFiles(false);
          $uploader->setFilesDispersion(false);
          $path = Mage::getBaseDir('media') . DS .'supermenu'. DS .'items' ;
          $uploader->save($path, $_FILES['icon_item']['name'] );
        } catch (Exception $e) {
          Mage::getSingleton('adminhtml/session')->addError(Mage::helper('supermenu')->__('Image not uploaded'));         
        }
        $data['icon_item'] = $_FILES['icon_item']['name']; 
      }// delete icons    
      elseif(isset($data['icon_item']['delete']) && $data['icon_item']['delete'] == 1) {
        $data['icon_item'] = '';
      }else{
        $data['icon_item'] = $model->getIconItem();
      }  


      $model = Mage::getModel('supermenu/supermenu');     
      $model->setData($data)      
      ->setId($this->getRequest()->getParam('id'));               
      try {
        if ($model->getCreatedTime() == NULL || $model->getUpdateTime() == NULL) {
          $model->setCreatedTime(now())
          ->setUpdateTime(now());
        } else {
          $model->setUpdateTime(now());
        }	

        $model->save();
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('supermenu')->__('Item was successfully saved'));
        Mage::getSingleton('adminhtml/session')->setFormData(false);

        if ($this->getRequest()->getParam('back')) {
          $this->_redirect('*/*/edit', array('id' => $model->getId()));
          return;
        }
        $this->_redirect('*/*/');
        return;
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        Mage::getSingleton('adminhtml/session')->setFormData($data);
        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
        return;
      }
    }
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('supermenu')->__('Unable to find item to save'));
    $this->_redirect('*/*/');
  }

  public function deleteAction() {
    if( $this->getRequest()->getParam('id') > 0 ) {
      try {
        $model = Mage::getModel('supermenu/supermenu');

        $model->setId($this->getRequest()->getParam('id'))
        ->delete();

        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
        $this->_redirect('*/*/');
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
      }
    }
    $this->_redirect('*/*/');
  }

  public function massDeleteAction() {
    $supermenuIds = $this->getRequest()->getParam('supermenu');
    if(!is_array($supermenuIds)) {
      Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
    } else {
      try {
        foreach ($supermenuIds as $supermenuId) {
          $supermenu = Mage::getModel('supermenu/supermenu')->load($supermenuId);
          $supermenu->delete();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess(
        Mage::helper('adminhtml')->__(
        'Total of %d record(s) were successfully deleted', count($supermenuIds)
        )
        );
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
      }
    }
    $this->_redirect('*/*/index');
  }

  public function massChangePositionAction() {
    $supermenuIds = $this->getRequest()->getParam('supermenu');
    if(!is_array($supermenuIds)) {
      Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    } else {
      try {
        foreach ($supermenuIds as $supermenuId) {
          $supermenu = Mage::getSingleton('supermenu/supermenu')
          ->load($supermenuId)
          ->setPosition($this->getRequest()->getParam('position'))          
          ->save();
        }
        $this->_getSession()->addSuccess(
        $this->__('Total of %d record(s) were successfully updated', count($supermenuIds))
        );
      } catch (Exception $e) {
        $this->_getSession()->addError($e->getMessage());
      }
    }
    $this->_redirect('*/*/index');
  }

  public function massStatusAction() {
    $supermenuIds = $this->getRequest()->getParam('supermenu');
    if(!is_array($supermenuIds)) {
      Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    } else {
      try {
        foreach ($supermenuIds as $supermenuId) {
          $supermenu = Mage::getSingleton('supermenu/supermenu')
          ->load($supermenuId)
          ->setStatus($this->getRequest()->getParam('status'))
          ->setIsMassupdate(true)
          ->save();
        }
        $this->_getSession()->addSuccess(
        $this->__('Total of %d record(s) were successfully updated', count($supermenuIds))
        );
      } catch (Exception $e) {
        $this->_getSession()->addError($e->getMessage());
      }
    }
    $this->_redirect('*/*/index');
  }

  public function exportCsvAction() {
    $fileName   = 'supermenu.csv';
    $content    = $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_grid')
    ->getCsv();

    $this->_sendUploadResponse($fileName, $content);
  }

  public function exportXmlAction() {
    $fileName   = 'supermenu.xml';
    $content    = $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_grid')
    ->getXml();

    $this->_sendUploadResponse($fileName, $content);
  }

  protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream') {
    $response = $this->getResponse();
    $response->setHeader('HTTP/1.1 200 OK','');
    $response->setHeader('Pragma', 'public', true);
    $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
    $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
    $response->setHeader('Last-Modified', date('r'));
    $response->setHeader('Accept-Ranges', 'bytes');
    $response->setHeader('Content-Length', strlen($content));
    $response->setHeader('Content-type', $contentType);
    $response->setBody($content);
    $response->sendResponse();
    die;
  }

  public function featuredCategoriesJsonAction() {
    $itemId = $this->getRequest()->getParam('id');
    $categoryModel = Mage::getModel('supermenu/supermenu')->load($itemId);          
    Mage::register('supermenu_data', $categoryModel); 
    $this->getResponse()->setBody(
    $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit_tab_content_categories')
    ->setFieldCategory('featured_categorys')
    ->setHidenInputId('featured_categorys')
    ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
    );
  } 

  public function categoriesJsonAction() {
    $itemId = $this->getRequest()->getParam('id');
    $categoryModel = Mage::getModel('supermenu/supermenu')->load($itemId);          
    Mage::register('supermenu_data', $categoryModel); 
    $this->getResponse()->setBody(
    $this->getLayout()->createBlock('supermenu/adminhtml_supermenu_edit_tab_content_categories')
    ->setFieldCategory('categorys_content')
    ->setHidenInputId('categorys_content')
    ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
    );
  }  

  public function chooserFeaturedProductsAction(){
    $request = $this->getRequest();
    $block = $this->getLayout()->createBlock(
    'supermenu/adminhtml_supermenu_edit_tab_content_featured_products', 'promo_widget_chooser_sku', array('js_form_object' => $request->getParam('form'),
    ));
    $block->setFormIdData('featured_products');
    if ($block) {
      $this->getResponse()->setBody($block->toHtml());
    }
  }

  public function chooserCurentProductsAction(){
    $request = $this->getRequest();
    $block = $this->getLayout()->createBlock(
    'supermenu/adminhtml_supermenu_edit_tab_content_sku', 'promo_widget_chooser_sku', array('js_form_object' => $request->getParam('form'),
    ));
    $block->setFormIdData('current_products');
    if ($block) {
      $this->getResponse()->setBody($block->toHtml());
    }
  }
}
