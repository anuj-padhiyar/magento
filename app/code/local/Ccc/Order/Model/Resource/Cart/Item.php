<?php

class Ccc_Order_Model_Resource_CArt_Item extends Mage_Core_Model_Resource_Db_Abstract{
    public function _construct(){
        $this->_init('order/cart_item','item_id');
    }
}
?>