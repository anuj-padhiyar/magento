<?php

class Ccc_Vendor_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
        parent::__construct();
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'vendor';
        $this->_headerText = 'Manage Products';
        $this->_removeButton('add');
    }
}