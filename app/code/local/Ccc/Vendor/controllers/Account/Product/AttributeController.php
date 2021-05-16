<?php 

class Ccc_Vendor_Account_Product_AttributeController extends Mage_Core_Controller_Front_Action{
    protected $_entityTypeId;
    
    public function indexAction(){
        if(!Mage::getModel('vendor/session')->getId()){  
            $this->_redirect('*/account/login');
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction(){
        $this->loadLayout();
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('vendor/resource_eav_attribute');
        if($id){
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('vendor/session')->addError(
                    Mage::helper('vendor')->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }
        Mage::register('product_attribute', $model);
        $this->renderLayout();
    }

    public function preDispatch(){
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType(Ccc_Vendor_Model_Resource_Product::ENTITY)->getTypeId();
    }

    public function saveAction(){
        $data = $this->getRequest()->getPost();
        if($data){
            $session = Mage::getSingleton('vendor/session');
            $model = Mage::getModel('vendor/resource_eav_attribute');
            $groupModel = Mage::getModel('eav/entity_attribute');
            $helper = Mage::helper('vendor/vendor');
            $id = $this->getRequest()->getParam('id');
            
            $data['attribute_code'] = strtolower(implode('_',explode(" ",$data['frontend_label'])));
            if (isset($data['attribute_code'])) {
                $validatorAttrCode = new Zend_Validate_Regex(array('pattern' => '/^(?!event$)[a-z][a-z_0-9]{1,254}$/'));
                if (!$validatorAttrCode->isValid($data['attribute_code'])) {
                    Mage::getSingleton('core/session')->addError(
                        Mage::helper('vendor')->__('Attribute code is invalid. Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter. Do not use "event" for an attribute code.'));
                    $this->_redirect('*/*/edit', array('id' => $id, '_current' => true));
                    return;
                }  
            }
            if (isset($data['frontend_input'])) {
                $validatorInputType = Mage::getModel('eav/adminhtml_system_config_source_inputtype_validator');
                if (!$validatorInputType->isValid($data['frontend_input'])) {
                    foreach ($validatorInputType->getMessages() as $message) {
                         Mage::getSingleton('core/session')->addError($message);
                    }
                    $this->_redirect('*/*/edit', array('id' => $id, '_current' => true));
                    return;
                }
            }
            
            if($id){
                if (!$model->load($id)->getId()) {
                     Mage::getSingleton('core/session')->addError(
                        Mage::helper('vendor')->__('This Attribute no longer exists'));
                    $this->_redirect('*/*/');
                    return;
                }
                $data['attribute_code'] = $model->getAttributeCode();
                $data['is_user_defined'] = $model->getIsUserDefined();
                $data['frontend_input'] = $model->getFrontendInput();
            }else{
                $data['source_model'] = $helper->getAttributeSourceModelByInputType($data['frontend_input']);
                $data['backend_model'] = $helper->getAttributeBackendModelByInputType($data['frontend_input']);
            }

            if (!isset($data['is_configurable'])) {
                $data['is_configurable'] = 0;
            }
            if (!isset($data['is_filterable'])) {
                $data['is_filterable'] = 0;
            }
            if (!isset($data['is_filterable_in_search'])) {
                $data['is_filterable_in_search'] = 0;
            }
            if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
                $data['backend_type'] = $model->getBackendTypeByInput($data['frontend_input']);
            }
            $defaultValueField = $model->getDefaultValueByInput($data['frontend_input']);
            if ($defaultValueField) {
                $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
            }
            if (!isset($data['apply_to'])) {
                $data['apply_to'] = array();
            }

            if(!$model->getId()){
                $data['attribute_code'] = $session->getId().'_'.$data['attribute_code'];
            }else{
                $data['attribute_code'] = $session->getId().'_'.strtolower(implode('_',explode(" ",$data['frontend_label'])));
            }

            $data = $this->_filterPostData($data);
            if(array_key_exists('group',$data)){
                $groupModel->setAttributeGroupId($data['group']);
                unset($data['group']);
            }

            $model->addData($data);
            if (!$id) {
                $model->setEntityTypeId($this->_entityTypeId);
                $model->setIsUserDefined(1);
            }
            if ($this->getRequest()->getParam('set') && $this->getRequest()->getParam('group')) {
                $model->setAttributeSetId($this->getRequest()->getParam('set'));
                $model->setAttributeGroupId($this->getRequest()->getParam('group'));
            }
            try {
                $model->save();
                $groupModel->setEntityTypeId($model->getEntityTypeId());
                $groupModel->setAttributeId($model->getAttributeId());
                $groupModel->setAttributeSetId(Mage::getModel('eav/entity_setup', 'core_setup')->getAttributeSetId('vendor_product', 'Default'));
                $groupModel->save();
                $session->addSuccess(
                    Mage::helper('vendor')->__('The vendor attribute has been saved.'));

                Mage::app()->cleanCache(array(Mage_Core_Model_Translate::CACHE_TAG));
                $session->setAttributeData(false);
                $this->_redirect('*/*/', array());
                return;
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                $session->setAttributeData($data);
                $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                return;
            }
            $this->_redirect('*/*/');
        }
    }

    protected function _filterPostData($data)
    {
        if ($data) {
            $helperCatalog = Mage::helper('vendor');
            $data['frontend_label'] = (array) $data['frontend_label'];
            foreach ($data['frontend_label'] as &$value) {
                if ($value) {
                    $value = $helperCatalog->stripTags($value);
                }
            }

            if (!empty($data['option']) && !empty($data['option']['value']) && is_array($data['option']['value'])) {
                $allowableTags = isset($data['is_html_allowed_on_front']) && $data['is_html_allowed_on_front']
                ? sprintf('<%s>', implode('><', $this->_getAllowedTags())) : null;
                foreach ($data['option']['value'] as $key => $values) {
                    foreach ($values as $storeId => $storeLabel) {
                        $data['option']['value'][$key][$storeId]
                        = $helperCatalog->stripTags($storeLabel, $allowableTags);
                    }
                }
            }
        }
        return $data;
    }

    public function deleteAction(){
        if ($id = $this->getRequest()->getParam('id')) {
            $model = Mage::getModel('vendor/resource_eav_attribute');
            $model->load($id);
            try {
                $model->delete();
                Mage::getSingleton('vendor/session')->addSuccess(
                    Mage::helper('vendor')->__('The Product attribute has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('vendor/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('vendor/session')->addError(
            Mage::helper('vendor')->__('Unable to find an attribute to delete.'));
        $this->_redirect('*/*/');
    }
}