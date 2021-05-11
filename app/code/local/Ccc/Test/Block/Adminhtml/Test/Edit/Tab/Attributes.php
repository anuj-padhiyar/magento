<?php 

class Ccc_Test_Block_Adminhtml_Test_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Widget_Form
{
	public function getTest(){
		return Mage::registry('current_test');
	}

	protected function _prepareLayout()
    {
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }        
        parent::_prepareLayout();
    }

    protected function _getAdditionalElementTypes()
    {
        $result = array(
            'price'    => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_price'),
            'gallery'  => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_gallery'),
            'image'    => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_image'),
            'boolean'  => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_boolean'),
            'textarea' => Mage::getConfig()->getBlockClassName('adminhtml/catalog_helper_form_wysiwyg')
        );

        $response = new Varien_Object();
        $response->setTypes(array());
        Mage::dispatchEvent('adminhtml_catalog_product_edit_element_types', array('response' => $response));

        foreach ($response->getTypes() as $typeName => $typeClass) {
            $result[$typeName] = $typeClass;
        }

        return $result;
    }

    protected function _prepareForm()
    {
        $group = $this->getGroup();
        $attributes = $this->getAttributes();

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $form->setDataObject($this->getTest());
        $form->setHtmlIdPrefix('group_' . $group->getId());
        $form->setFieldNameSuffix('account');


        $fieldset = $form->addFieldset('fieldset_group_' . $group->getId(), array(
            'legend'    => Mage::helper('test')->__($group->getAttributeGroupName()),
            'class'     => 'fieldset',
        ));

        $this->_setFieldset($attributes, $fieldset);
        $form->addValues($this->getTest()->getData());

        return parent::_prepareForm();
    }
}

?>