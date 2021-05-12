<?php 

class Ccc_Seller_Adminhtml_SellerController extends Mage_Adminhtml_Controller_Action
{
	public function _initAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('Ccc/Seller')
			 ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Seller'),Mage::helper('adminhtml')->__('Manage Seller'));
		return $this;
	}

	public function indexAction()
	{
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('seller/adminhtml_seller'));
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		$sellerId = $this->getRequest()->getParam('id');
		$sellerModel = Mage::getModel('ccc_seller/data')->load($sellerId);
		if ($sellerModel->getData() || $sellerId == 0) {
			Mage::register('seller_data',$sellerModel);
			$this->loadLayout();
			$this->_setActiveMenu('Ccc/Seller');
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('seller/adminhtml_seller_edit'));
			$this->renderLayout();
		}
		else
		{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('seller')->__('Seller not exist.'));
			$this->_redirect('*/*/');
		}
	}

	public function saveAction()
	{
		if ($this->getRequest()->getPost())
		{
			try
			{
				$postData = $this->getRequest()->getPost();
				$id = $this->getRequest()->getParam('id');
				$sellerModel = Mage::getModel('ccc_seller/data')->load($id);
				if ($sellerModel->getId()) 
				{
					$sellerModel->setName($postData['name'])
					->save();
				}
				else
				{
					$sellerModel->setId($this->getRequest()->getParam('id'))
					->setName($postData['name'])
					->save();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('seller')->__('Seller was successfully saved.'));
				Mage::getSingleton('adminhtml/session')->setSellerData(false);
				$this->_redirect('*/*/');
				return;
			}
			catch(Exception $e)
			{
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setSellerData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit',array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			$this->_redirect('*/*/');
		}
	}

	public function deleteAction()
	{
		if ($this->getRequest()->getParam('id') > 0) {
			try
			{
				$sellerModel = Mage::getModel('ccc_seller/data');
				$sellerModel->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('seller')->__('Seller was successfully deleted.'));
				$this->_redirect('*/*/');
			}
			catch(Exception $e)
			{
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setSellerData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit',array('id' => $this->getRequest()->getParam('id')));
			}
			$this->_redirect('*/*/');
		}
	}
}

?>