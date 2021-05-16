<?php

class Ccc_Vendor_Block_Account_Dashboard_Info extends Mage_Core_Block_Template
{
    public function getVendor()
    {
        return Mage::getSingleton('vendor/session')->getVendor();
    }

    public function getChangePasswordUrl()
    {
        return Mage::getUrl('*/account/edit/changepass/1');
    }

    /**
     * Get Vendor Subscription Object Information
     *
     * @return Mage_Newsletter_Model_Subscriber
     */
    // public function getSubscriptionObject()
    // {
    //     if(is_null($this->_subscription)) {
    //         $this->_subscription = Mage::getModel('newsletter/subscriber')->loadByVendor(
    //             Mage::getSingleton('vendor/session')->getVendor()
    //         );
    //     }

    //     return $this->_subscription;
    // }

    /**
     * Gets Vendor subscription status
     *
     * @return bool
     */
    // public function getIsSubscribed()
    // {
    //     return $this->getSubscriptionObject()->isSubscribed();
    // }
}

?>