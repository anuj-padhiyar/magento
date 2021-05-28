<?php 

class Ccc_Order_Model_Cart extends Mage_Core_Model_Abstract{
    public function _construct(){
        $this->_init('order/cart');
    }

    public function getCartBillingAddress(){
        $cartAddress = Mage::getModel('order/cart_address');
        $cartId = $this->getId();
        $collection = $cartAddress->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$cartId])
                        ->addFieldToFilter('address_type',['eq'=>'billing']);

        if($collection->count() == 1){
            return $collection->getData()[0];
        }
        return false;
    }

    public function getCartShippingAddress(){
        $cartAddress = Mage::getModel('order/cart_address');
        $cartId = $this->getId();
        $collection = $cartAddress->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$cartId])
                        ->addFieldToFilter('address_type',['eq'=>'shipping']);

        if($collection->count() == 1){
            return $collection->getData()[0];
        }
        return false;
    }

    public function getItems(){
        $collection = Mage::getModel('order/cart_item')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$this->getId()]);
        return $collection;
    }
    
}