<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_BillingAddress extends Ccc_Order_Block_Adminhtml_Order_Cart{
    public function __construct(){
        parent::__construct();
    }

    public function getBillingAddress(){
        $cart = $this->getCart();
        if($address = $cart->getCartBillingAddress()){
            return $address;
        }
        if($address = $this->getCustomerBillingAddress()){
            $address['country'] = $address['country_id'];
            $address['address'] = $address['street'];
            $address['state'] = $address['region'];
            $address['zipcode'] = $address['postcode'];
            $address['first_name'] = $address['firstname'];
            $address['last_name'] = $address['lastname'];
            return $address;
        }
        return false;
    }

    public function getCustomerBillingAddress(){
        $customerId = $this->getRequest()->getParam('id');
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $address = $customer->getDefaultBillingAddress();
        if($address){
            return $address->getData();
        }
    }

    public function getValue($address, $value){
        if(array_key_exists($value,$address)){
            return $address[$value];
        }
        return false;
    }

    public function getsaveBillingUrl(){
        return $this->getUrl('*/*/billingAddress',array('_current'=>true));
    }

    public function getCountryOptions(){
        return Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
    }
}