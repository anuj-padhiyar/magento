<?php 

class Ccc_Order_Block_Adminhtml_Order_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
        $this->_controller = 'adminhtml_order_customer';
        $this->_blockGroup = 'order';
        $this->_headerText = Mage::helper('order')->__('Create New Order');
        $this->_addButtonLabel = "Create New Customer";
        $this->addButton ('back', [
            'label' =>  'Back',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/order/index') . '\')',
            'class'     =>  'back'
        ], 0, 1,  'header');
        parent::__construct();
    }

    public function getCreateUrl(){
        return $this->getUrl('*/customer/new');
    }
}
