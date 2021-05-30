<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Account extends Ccc_Order_Block_Adminhtml_Order_Cart{
    protected $customer = null;
    public function __construct(){
        parent::__construct();
    }

    public function getCustomer(){
        if(!$this->customer){
            $this->setCustomer();
        }
        return $this->customer;
    }
    public function setCustomer(){
        $id = $this->getCart()->getCustomerId();
        $this->customer = Mage::getModel('customer/customer')->load($id);
        return $this;
    }

    public function getCustomerName(){
        $customer = $this->getCustomer();
        return $customer->getFirstname().' '.$customer->getMiddlename().' '.$customer->getLastname();
    }

    public function getCustomerEmail(){
        return $this->getCustomer()->getEmail();
    }
}