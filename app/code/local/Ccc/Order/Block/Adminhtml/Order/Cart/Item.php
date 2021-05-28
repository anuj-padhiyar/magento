<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Item extends Ccc_Order_Block_Adminhtml_Order_Cart{
    public function __construct(){
        parent::__construct();
    }

    public function getCollection(){
        return $this->getCart()->getItems();
    }

    public function getProductName($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getName();   
    }

    public function getProductSKU($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getSku();
    }

    public function getUpdateUrl(){
        return $this->getUrl('*/adminhtml_order/changeQuantity',array('_current' => true));
    }

    public function getDeleteItemUrl($id){
        return $this->getUrl('*/adminhtml_order/deleteItem',array('_current' => true,'itemId'=>$id));
    }
}