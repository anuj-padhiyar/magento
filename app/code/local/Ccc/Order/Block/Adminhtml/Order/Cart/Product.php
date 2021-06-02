<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Product extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
        $this->_controller = 'adminhtml_order_cart_product';
        $this->_blockGroup = 'order';
        $this->_headerText = 'Select Product';
        parent::__construct();
        $this->_removeButton('add');
      //   $data = array(
      //     'label' =>  'Add Product To Cart',
      //     'onclick'   => 'getData()',
      //     'class'     =>  'save'
      //    );
      //   $this->addButton ('approve', $data, 1, 0,  'header'); 
      }
}
