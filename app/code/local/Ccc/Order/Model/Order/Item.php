<?php 

class Ccc_Order_Model_Order_Item extends Mage_Core_Model_Abstract{
    protected $product = null;
    public function _construct(){
        $this->_init('order/order_item');
    }

    public function getTotalByQuantityPrice(){
        return $this->getQuantity() * $this->getBasePrice();
    }

    public function getProduct(){
        if(!$this->product){
            $this->setProduct();
        }
        return $this->product;
    }
    public function setProduct(){
        $this->product = Mage::getModel('catalog/product')->load($this->getProductId());
        return $this;
    }
}