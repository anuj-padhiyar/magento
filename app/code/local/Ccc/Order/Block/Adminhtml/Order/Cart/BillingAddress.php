<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_BillingAddress extends Ccc_Order_Block_Adminhtml_Order_Cart
{
    public function __construct(){
        parent::__construct();
    }

    public function getBillingAddress(){
        $cart = $this->getCart();
        if ($cart->getCartBillingAddress()->getId()) {
            return $cart->getCartBillingAddress();
        }
        if ($cart->getCustomer()->getCustomerBillingAddress()->getId()) {
            $address = $cart->getCustomer()->getCustomerBillingAddress();
            $address->setCountry($address->getCountryId());
            $address->setAddress($address->getStreet());
            $address->setState($address->getRegion());
            $address->setZipcode($address->getPostcode());
            $address->setFirstName($address->getFirstname());
            $address->setLastName($address->getLastname());
            return $address;
        }
        return Mage::getModel('order/cart_address');
    }

    public function getValue($address, $value){
        if (array_key_exists($value, $address)) {
            return $address[$value];
        }
        return false;
    }

    public function getsaveBillingUrl(){
        return $this->getUrl('*/*/billingAddress', array('_current' => true));
    }

    public function getCountryOptions(){
        return Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
    }
}
