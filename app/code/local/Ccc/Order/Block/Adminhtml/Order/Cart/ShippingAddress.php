<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_ShippingAddress extends Ccc_Order_Block_Adminhtml_Order_Cart{
    public function __construct(){
        parent::__construct();
    }

    public function getShippingAddress(){
        $cart = $this->getCart();
        if($address = $cart->getCartShippingAddress()){
            return $address;
        }
        if($address = $this->getCustomerShippingAddress()){
            $address['country'] = $address['country_id'];
            $address['address'] = $address['street'];
            $address['state'] = $address['region'];
            $address['zipcode'] = $address['postcode'];
            $address['first_name'] = $address['firstname'];
            $address['last_name'] = $address['lastname'];
            return $address;
        }
        return null;
    }

    public function getCustomerShippingAddress(){
        $customerId = $this->getRequest()->getParam('id');
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $address = $customer->getDefaultShippingAddress();
        if($address){
            return $address->getData();
        }
        return false;
    }

    public function getValue($address, $value){
        if(array_key_exists($value,$address)){
            return $address[$value];
        }
        return false;
    }

    public function getShippingMethodUrl(){
        return $this->getUrl('*/*/shippingAddress',array('_current'=>true));
    }

    public function getCountryOptions(){
        return Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
    }
}