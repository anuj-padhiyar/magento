<?php

class Ccc_Test_Block_Adminhtml_Test_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('test_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('test')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('test')->__('Properties'),
            'title'     => Mage::helper('test')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('test/adminhtml_test_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('test')->__('Manage Label / Options'),
            'title'     => Mage::helper('test')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('test/adminhtml_test_attribute_edit_tab_options')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }

}