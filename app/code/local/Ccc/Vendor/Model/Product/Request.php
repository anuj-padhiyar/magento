<?php

class Ccc_Vendor_Model_Product_Request extends Mage_Core_Model_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('vendor/product_request');
    }
}