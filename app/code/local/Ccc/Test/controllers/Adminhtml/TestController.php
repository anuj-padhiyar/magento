<?php

class Ccc_Test_Adminhtml_TestController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('test');
        $this->_title('Test Grid');
        $this->_addContent($this->getLayout()->createBlock('test/adminhtml_test'));
        $this->renderLayout();
    }

    protected function _initTest()
    {
        $this->_title($this->__('Test'))
            ->_title($this->__('Manage Tests'));

        $testId = (int) $this->getRequest()->getParam('id');
        $test = Mage::getModel('test/test')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($testId);

        if (!$testId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $test->setAttributeSetId($setId);
            }
        }

        Mage::register('current_test', $test);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $test;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $testId = (int) $this->getRequest()->getParam('id');
        $test = $this->_initTest();

        if ($testId && !$test->getId()) {
            $this->_getSession()->addError(Mage::helper('test')->__('This test no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($test->getName());
        $this->loadLayout();
        $this->_setActiveMenu('test/test');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $testData = $this->getRequest()->getPost('account');
            $test = Mage::getSingleton('test/test');
            $test->setAttributeSetId($setId);

            if ($testId = $this->getRequest()->getParam('id')) {
                if (!$test->load($testId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }

            $test->addData($testData);

            $test->save();

            Mage::getSingleton('core/session')->addSuccess("test data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $testModel = Mage::getModel('test/test');

            if (!($testId = (int) $this->getRequest()->getParam('id'))) {
                throw new Exception('Id not found');
            }

            if (!$testModel->load($testId)) {
                throw new Exception('test does not exist');
            }

            if (!$testModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The test has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*/');
    }
}
