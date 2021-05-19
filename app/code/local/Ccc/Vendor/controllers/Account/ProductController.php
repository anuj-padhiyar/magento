<?php 

class Ccc_Vendor_Account_ProductController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){
        if (!Mage::getSingleton('vendor/session')->isLoggedIn()) {
            $this->_redirect('*/account/login');
            return;
        }
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
        $this->renderLayout();
    }

    protected function _initProduct()
    {
        $productId = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('vendor/product')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($productId);

        if (!$productId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }
        }

        Mage::register('current_product', $product);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $product;
    }

    public function editAction()
    {
        $productId = (int) $this->getRequest()->getParam('id');
        $product = $this->_initProduct();
        
        if ($productId && !$product->getId()) {
            Mage::getSingleton('vendor/session')->addError(Mage::helper('product')->__('This meet no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    public function validateSku($curSku){
        $vendorId = Mage::getModel('vendor/session')->getId();
        $id = $this->getRequest()->getParam('id');
        $collection =  Mage::getResourceModel('vendor/product_collection');
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection
            ->joinAttribute( 
                'sku',
                'vendor_product/sku',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
        $collection->addFieldToFilter('sku',['like'=>$vendorId.'_%']);
        if(!$collection->count()){
            return null;
        }
        foreach($collection->getData() as $key=>$value){
            if($id && $id == $value['entity_id']){
                continue;
            }
            if($curSku == $value['sku']){
                return true;
            }
        }
        return false;
    }

    public function saveAction(){
        try{
            
            if(!$this->getRequest()->isPost()){
                Mage::getSingleton('core/session')->addSuccess("Opps Getting Error");
                $this->_redirect('*/*/');
                return;
            }
            
            $data = $this->getRequest()->getPost();
            $vendorId = Mage::getModel('vendor/session')->getId();
            $id = $this->getRequest()->getParam('id');
           
            if(!is_numeric($data['weight']) || !is_numeric($data['price']) || $data['price']<0 || $data['weight']<0){
                Mage::getSingleton('core/session')->addError("Weight And Price Should be Numerical And Valid.");
                $this->_redirect('*/*/edit',array('_current'=>true));
                return;
            }
            //$model = Mage::getSingleton('vendor/product');
            if($id){
                $model->load($id);
            }
            $vendorProduct = Mage::getModel('vendor/product');
            $entityTypeId = $vendorProduct->getResource()->getEntityType()->getId();
            $attributeSetId = $vendorProduct->getResource()->getEntityType()->getDefaultAttributeSetId();
            
            $model->addData($data);
            $model->sku = $vendorId.'_'.$model->sku;
            if($this->validateSku($model->sku)){
                Mage::getSingleton('core/session')->addError("SKU already exists");
                Mage::register('current_product', $model);
                $this->_redirect('*/*/edit',array('_current'=>true));
                return;
            }
            if(!$id){
                $model->setEntityTypeId($entityTypeId);
                $model->setAttributeSetId($attributeSetId);
            }
            $model->save();

            $productRequest = Mage::getModel('vendor/product_request');
            $productRequest->setVendorId($vendorId);
            $productRequest->setProductId($model->getId());
            if($id){
                $productRequest->setRequestType('edit');
            }else{
                $productRequest->setRequestType('add');
            }
            $productRequest->setRequestStatus('pending');
            date_default_timezone_set('Asia/Kolkata');
            $productRequest->setRequestDate(date('j/m/Y  h:i:s A'));
            $productRequest->save();
            
            Mage::getSingleton('core/session')->addSuccess("Request Sended For Vendor Add/Edit");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $vendorId = Mage::getModel('vendor/session')->getId();
        $productRequest = Mage::getModel('vendor/product_request');
        $productRequest->setVendorId($vendorId);
        $productRequest->setProductId($id);
        $productRequest->setRequestType('delete');
        $productRequest->setRequestStatus('pending');
        date_default_timezone_set('Asia/Kolkata');
        $productRequest->setRequestDate(date('j/m/Y  h:i:s A'));
        $productRequest->save();
        Mage::getSingleton('core/session')->addSuccess("Delete Request Sent");
        $this->_redirect("*/*/");
    }
    
    

}