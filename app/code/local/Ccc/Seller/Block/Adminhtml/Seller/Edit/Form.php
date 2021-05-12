<?php 

class Ccc_Seller_Block_Adminhtml_Seller_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(
			array(
				'id'=>'edit_form',
				'action'=>$this->getUrl('*/*/save',array('id'=>$this->getRequest()->getParam('id'))),
				'method'=>'post'
				)
			);
		$form->setUseContainer(true);
		$this->setForm($form);

		$fieldset = $form->addFieldSet('seller_form',array('legend'=>Mage::helper('seller')->__('Seller Information')));

		$fieldset->addField('name','text',array(
			'label'=>Mage::helper('seller')->__('Name'),
			'class'=>'requierd-entry',
			'requierd'=> true,
			'name'=>'name'
		));

		/*if (Mage::getSingleton('adminhtml/session')->getSellerData())
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getSellerData());
			Mage::getSingleton('adminhtml/session')->setSellerData(null);				
		}*/
		if (Mage::registry('seller_data'))
		{
			$form->setValues(Mage::registry('seller_data')->getData());
		}

		return parent::_prepareForm();
	}
}
?>