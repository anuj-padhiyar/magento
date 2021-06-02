<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Item extends Ccc_Order_Block_Adminhtml_Order_Cart{
    public function __construct(){
        parent::__construct();
    }

    public function getCollection(){
        return $this->getCart()->getItems();
    }

    public function getUpdateUrl(){
        return $this->getUrl('*/*/changeQuantity');
    }

    public function getDeleteItemUrl($id){
        return $this->getUrl('*/*/deleteItem',array('itemId'=>$id));
    }
}
