<?php 

class Ccc_Order_Model_Order extends Mage_Core_Model_Abstract{
    protected $billingAddress = null;
    protected $shippingAddress = null;
    protected $items = null;
    protected $subtotal = null;
    protected $finalTotal = null;
    protected $customer = null;
    protected $status = null;
    protected $lastStatus = null;

    public function _construct(){
        $this->_init('order/order');
    }

    public function setBillingAddress(){
        $orderId = $this->getId();
        if(!$orderId){
            return false;
        }
        $collection = Mage::getModel('order/order_address')->getCollection()
                        ->addFieldToFilter('order_id',['eq'=>$orderId])
                        ->addFieldToFilter('address_type',['eq'=>'billing']);
        $this->billingAddress = $collection->getFirstItem();
        return $this;
    }
    public function getBillingAddress(){
        if(!$this->billingAddress){
            $this->setBillingAddress();
        }
        return $this->billingAddress;
    }

    public function setShippingAddress(){
        $orderId = $this->getId();
        if(!$orderId){
            return false;
        }
        $collection = Mage::getModel('order/order_address')->getCollection()
                        ->addFieldToFilter('order_id',['eq'=>$orderId])
                        ->addFieldToFilter('address_type',['eq'=>'shipping']);
        $this->shippingAddress = $collection->getFirstItem();
        return $this;
    }
    public function getShippingAddress(){
        if(!$this->shippingAddress){
            $this->setShippingAddress();
        }
        return $this->shippingAddress;
    }

    public function setItems(){
        $collection = Mage::getModel('order/order_item')->getCollection()
                        ->addFieldToFilter('order_id',['eq'=>$this->getId()]);
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

    public function getStatus(){
        if(!$this->status){
            $this->setStatus();
        }
        return $this->status;
    }
    public function setStatus(){
        $status = Mage::getModel('order/order_status')->getCollection()
                    ->addFieldToFilter('order_id',['eq'=>$this->getId()]);
        $this->status = $status->getItems();
        return $this;
    }

    public function getLastStatus(){
        if(!$this->lastStatus){
            $this->setLastStatus();
        }
        return $this->lastStatus;
    }
    public function setLastStatus(){
        $lastStatus = Mage::getModel('order/order_status')->getCollection()
                    ->addFieldToFilter('order_id',['eq'=>$this->getId()]);
        
        $this->lastStatus = $lastStatus->getLastItem();
        return $this;
    }

}