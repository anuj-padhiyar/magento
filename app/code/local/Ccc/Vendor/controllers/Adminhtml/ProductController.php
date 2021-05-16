<?php

class Ccc_Vendor_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action{
    public function indexAction(){
        $this->loadLayout();
        $this->_setActiveMenu('vendor');
        $this->_title('Product Request Grid');
        $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_product'));
        $this->renderLayout();
    }
    
    public function editAction(){
        $requestId = $this->getRequest()->getParam('id');
        $request = Mage::getModel('vendor/product_request')->load($requestId);
        $product = Mage::getModel('vendor/product')->load($request->getProductId());
        Mage::register('product',$product);

        $this->loadLayout();
        $this->_setActiveMenu('vendor/vendor');
        $this->renderLayout();
    }
    
    public function acceptAction(){
        $requestId = $this->getRequest()->getParam('id');
        $model = Mage::getModel('vendor/product_request')->load($requestId);
        $productModel = Mage::getModel('vendor/product')->load($model->getProductId());
        $requestType = $model->getRequestType();
        if($requestType == 'delete'){
            $productModel->delete();
        }else{
            $catalogProduct = Mage::getModel('catalog/product')
                                    ->setData($productModel->getData())
                                    ->save();
            $model->setCatalogProductId($catalogProduct->getId());
        }
        date_default_timezone_set('Asia/Kolkata');
        $model->setRequestApprovedDate(date('j/m/Y  h:i:s A'));
        $model->setRequestStatus('approved');
        $model->save();
        $this->_redirect('*/*/');
    }

    public function rejectAction(){
        $requestId = $this->getRequest()->getParam('id');
        $model = Mage::getModel('vendor/product_request')->load($requestId);
        $model->setRequestStatus('unapproved');
        $model->save();
        $this->_redirect('*/*/');
    }
}

?>