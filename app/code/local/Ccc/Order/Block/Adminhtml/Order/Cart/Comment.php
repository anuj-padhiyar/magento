<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Comment extends Ccc_Order_Block_Adminhtml_Order_Cart{
    public function __construct(){
        parent::__construct();
    }

    public function getComment(){
        return $this->getCart()->getComment();
    }

    public function getCommentSaveUrl(){
        return $this->getUrl('*/*/saveComment',array('_current'=>true));
    }
}
