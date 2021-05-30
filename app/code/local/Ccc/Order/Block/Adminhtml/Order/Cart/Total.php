<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Total extends Ccc_Order_Block_Adminhtml_Order_Cart{
    public function __construct(){
        parent::__construct();
    }

    public function getSubTotal(){
        return $this->getCart()->getSubTotal();
    }

    public function getShippingAmount(){
        return $this->getCart()->getShippingAmount();
        // die;
        // if($amount = $this->getCart()->getShippingAmount()){
        //     return $amount;
        // }
        // return 0;
    }

    public function getFinalTotal(){
        return $this->getCart()->getFinalTotal();
    }

    public function getSaveUrl(){
        return $this->getUrl('*/*/placeOrder');
    }
}