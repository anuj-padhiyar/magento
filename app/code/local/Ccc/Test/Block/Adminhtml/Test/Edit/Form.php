<?php 

class Ccc_Test_Block_Adminhtml_Test_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	public function __construct(){
		parent::__construct();
	}

	public function _prepareForm(){
		$form = new Varien_Data_Form(array(
			'id'=>'edit_form',
			'action'=>$this->getUrl('*/*/save',array('id'=>$this->getRequest()->getParam('id'),'set'=>$this->getRequest()->getParam('set'))),
			'method'=>'post',
			'enctype' => 'multipart/form-data',
		));

		$form->setUseContainer(true);
		$this->SetForm($form);

		return parent::_prepareForm();
	}
}

?>