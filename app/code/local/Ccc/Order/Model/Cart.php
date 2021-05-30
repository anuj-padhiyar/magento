<?php 

class Ccc_Order_Model_Cart extends Mage_Core_Model_Abstract{
    protected $cartBillingAddress = null;
    protected $cartShippingAddress = null;
    protected $items = null;
    protected $subtotal = null;
    protected $finalTotal = null;
    protected $customer = null;
    protected $itemIds = [];

    public function _construct(){
        $this->_init('order/cart');
    }

    public function setCartBillingAddress(){
        $cartId = $this->getId();
        if(!$cartId){
            return false;
        }
        $collection = Mage::getModel('order/cart_address')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$cartId])
                        ->addFieldToFilter('address_type',['eq'=>'billing']);
        $this->cartBillingAddress = $collection->getFirstItem();
        return $this;
    }
    public function getCartBillingAddress(){
        if(!$this->cartBillingAddress){
            $this->setCartBillingAddress();
        }
        return $this->cartBillingAddress;
    }

    public function setCartShippingAddress(){
        $cartId = $this->getId();
        if(!$cartId){
            return false;
        }
        $collection = Mage::getModel('order/cart_address')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$cartId])
                        ->addFieldToFilter('address_type',['eq'=>'shipping']);
        $this->cartShippingAddress = $collection->getFirstItem();
        return $this;
    }
    public function getCartShippingAddress(){
        if(!$this->cartShippingAddress){
            $this->setCartShippingAddress();
        }
        return $this->cartShippingAddress;
    }

    public function setItems(){
        $collection = Mage::getModel('order/cart_item')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$this->getId()]);
        $this->items = $collection;
        return $this;
    }
    public function getItems(){
        if(!$this->items){
            $this->setItems();
        }
        return $this->items;
    }

    public function setSubtotal(){
        $items = $this->getItems();
        $this->subtotal =0;
        foreach($items as $key=>$item){
            $this->subtotal += $item->getTotalByQuantityPrice();
        }
        return $this;
    }
    public function getSubtotal(){
        if(!$this->subtotal){
            $this->setSubtotal();
        }
        return $this->subtotal;
    }
    
    public function setFinalTotal(){
        $this->finalTotal = $this->getSubTotal() + $this->getShippingAmount();
        return $this;
    }
    public function getFinalTotal(){
        if(!$this->finalTotal){
            $this->setFinalTotal();
        }
        return $this->finalTotal;
    }

    public function getCustomer(){
        if(!$this->customer){
            $this->setCustomer();
        }
        return $this->customer;
    }
    public function setCustomer(){
        if(!$this->getId()){
            return false;
        }
        if(!$this->getCustomerId()){
            return false;
        }
        $customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
        $this->customer = $customer;
        return $this;
    }

    public function setItemIds(){
        $ids = [];
        $collection = Mage::getModel('order/cart_item')->getCollection()
                        ->addFieldToFilter('cart_id',['eq'=>$this->getId()]);
        if($collection->count()){
            foreach($collection->getData() as $key=>$value){
                $ids[$value['item_id']] = $value['product_id'];
            }
        }
        $this->itemIds = $ids;
        return $this;
    }

    public function getItemIds(){
        if(!$this->itemIds){
            $this->setItemIds();
        }
        return $this->itemIds;
    }
}