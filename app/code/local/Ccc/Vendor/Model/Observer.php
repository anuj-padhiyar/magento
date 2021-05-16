<?php
class Ccc_Vendor_Model_Observer
{
    public function beforeLoadLayout($observer)
    {
        echo "<pre>";
        print_r($observer);
        die;
        $loggedIn = Mage::getSingleton('vendor/session')->isLoggedIn();
        $observer->getEvent()->getLayout()->getUpdate()
           ->addHandle('vendor_logged_' . ($loggedIn ? 'in' : 'out'));
    }
}

?>