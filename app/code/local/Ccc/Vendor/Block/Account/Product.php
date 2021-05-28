<?php

class Ccc_Vendor_Block_Account_Product extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function _construct(){
        $this->_controller = 'account_product';
        $this->_blockGroup = 'vendor';
        $this->_addButtonLable = $this->__('Add Product');
        $this->_headerText = 'Manage Products';
    }
}