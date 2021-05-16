<?php

class Ccc_Vendor_Block_Account_Product_Edit extends Mage_Core_Block_Template{
    public function getHeaderText(){
        if(Mage::registry('current_product')->getId()){
            return Mage::helper('vendor')->__('Edit Product');
        }else{
            return Mage::helper('vendor')->__('Add Product');
        }
    }

    public function getSaveUrl(){
        return $this->getUrl('*/*/save', array('_current'=>true, 'back'=>null));
    }
}