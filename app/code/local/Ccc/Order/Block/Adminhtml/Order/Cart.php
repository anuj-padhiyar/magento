<?php

class Ccc_Order_Block_Adminhtml_Order_Cart extends Mage_Core_Block_Template{
    public function __construct(){
        parent::__construct();
    }

    public function getBackUrl(){
        return $this->getUrl('*/*/showCustomer');
    }

    public function getSaveUrl(){
        return $this->getUrl('*/*/placeOrder',array('_current'=>true));
    }

    public function getCart(){
        return Mage::registry('cart');
    }
    
}