<?php 

class Ccc_Vendor_Account_Product_GroupController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){ 
        if(!Mage::getModel('vendor/session')->isLoggedIn()){
            $this->_redirect('*/account/login');
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function deleteAction(){
        if ($id = $this->getRequest()->getParam('id')) {
            $groupModel = Mage::getModel('eav/entity_attribute_group')->load($id);
            try {
                $groupModel->delete();
                Mage::getSingleton('core/session')->addSuccess(
                    Mage::helper('vendor')->__('The attribute group has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('core/session')->addError(
            Mage::helper('vendor')->__('Unable to find an Attribute Group to delete.'));
        $this->_redirect('*/*/');
    }

    public function saveAction(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        $data = $this->getRequest()->getPost(); 
        $id = $this->getRequest()->getParam('id');
        
        $model = Mage::getModel('vendor/product_attribute_group');
        $collection = Mage::getResourceModel('vendor/product_attribute_group_collection')
                        ->addFieldToFilter('vendor_id',array('eq',$vendorId));
        if($collection){
            foreach($collection->getData() as $key=>$value){
                if(strtolower($value['attribute_group_name']) == strtolower($data['attribute_group_name'])){
                    if($id && $value['group_id'] == $id){
                        continue;
                    }
                    Mage::getSingleton('core/session')->addError(
                        Mage::helper('vendor')->__('This Group is already exists in Database'));
                    $this->_redirect('*/*/edit',['_current'=>true]);
                    return;
                }
            }
        }

        $coreModel = Mage::getModel('eav/entity_attribute_group');
        if($id){
            $model->load($id);
            $coreModel->load($model->getAttributeGroupId());
            $coreModel->setAttributeGroupName($vendorId."_".strtolower($data['attribute_group_name']));
            $coreModel->save();
        }else{
            $default_set_id = Mage::getModel('eav/entity_setup', 'core_setup')->getAttributeSetId('vendor_product', 'Default');
            $coreModel->setAttributeSetId($default_set_id);
            $coreModel->setAttributeGroupName($vendorId."_".strtolower($data['attribute_group_name']));
            $coreModel->save();
            $model->setVendorId($vendorId);
            $model->setAttributeGroupId($coreModel->getId());
        }
        $model->setAttributeGroupName($data['attribute_group_name']);
        $model->save();
        Mage::getSingleton('core/session')->addSuccess(
            Mage::helper('vendor')->__('Group Saved'));
        $this->_redirect("*/*/");
    }

    public function validateGroup(){

    }

    public function editAction(){
        $this->loadLayout();
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('vendor/product_attribute_group');
        if($id){
            $model->load($id);
            if(!$model->getId()){
                Mage::getSingleton('core/session')->addError(
                    Mage::helper('vendor')->__('This group no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }
        Mage::register('group', $model);
        $this->renderLayout();
    }

    public function removeAttributeAction(){
        $data = $this->getRequest()->getPost();
        $groupId = Mage::getModel('vendor/product_attribute_group')
                        ->load($this->getRequest()->getParam('id'))
                        ->getAttributeGroupId();
        foreach($data as $id=>$value){
            $writeConnnection = Mage::getSingleton('core/resource')->getConnection('core_write');
            $id = $writeConnnection 
                    ->delete('eav_entity_attribute',
                    "attribute_group_id={$groupId} AND attribute_id = {$id}");
            if($id){
                Mage::getSingleton('core/session')->addSuccess(Mage::helper('vendor')->__('Attribute Deleted'));
                $this->_redirect("*/*/edit",['id'=>$this->getRequest()->getParam('id')]);
                return;
            }
        }
    }
}