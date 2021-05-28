<?php

class Ccc_Vendor_Block_Account_Dashboard_Hello extends Mage_Core_Block_Template
{
    public function getVendorName()
    {
        $first = Mage::getSingleton('vendor/session')->getVendor()->getfirstname();
        $middle = Mage::getSingleton('vendor/session')->getVendor()->getmiddlename();
        $last = Mage::getSingleton('vendor/session')->getVendor()->getlastname();
        return $first.' '.$middle.' '.$last;
    }

}
