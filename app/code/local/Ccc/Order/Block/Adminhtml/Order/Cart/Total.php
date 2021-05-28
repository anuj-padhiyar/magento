<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Total extends Ccc_Order_Block_Adminhtml_Order_Cart{
    protected $subtotal = 0;
    protected $finaltotal = 0;
    public function __construct(){
        parent::__construct();
    }

    public function setSubtotal(){
        $cart = $this->getCart();
        $items = $cart->getItems();
        foreach($items as $key=>$item){
            $this->subtotal += $this->getTotalByQuantityPrice($item['quantity'],$item['price']);
        }
        return $this;
    }

    public function getSubTotal(){
        if(!$this->subtotal){
            $this->setSubtotal();
        }
        return $this->subtotal;
    }

    public function getTotalByQuantityPrice($quantity, $price){
        return $quantity*$price;
    }

    public function getShippingAmount(){
        if($amount = $this->getCart()->getShippingAmount()){
            return $amount;
        }
        return 0;
    }

    public function getFinalTotal(){
        return $this->getSubTotal() + $this->getShippingAmount();
    }

    public function getSaveUrl(){
        return $this->getUrl('*/*/placeOrder',array('_current'=>true));
    }
}