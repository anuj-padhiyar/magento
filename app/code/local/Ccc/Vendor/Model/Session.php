<?php
class Ccc_Vendor_Model_Session extends Mage_Core_Model_Session_Abstract
{
    protected $_vendor;
    
    public function __construct(){
        $this->init('adminhtml');
    }

    public function isLoggedIn(){
        return (bool)$this->getId() && (bool)$this->checkVendorId($this->getId());
    }

    public function checkVendorId($vendorId){
        if ($this->_isVendorIdChecked === null) {
            $this->_isVendorIdChecked = Mage::getResourceSingleton('vendor/vendor')->checkVendorId($vendorId);
        }
        return $this->_isVendorIdChecked;
    }

    public function login($username, $password){
        $vendor = Mage::getModel('vendor/vendor')
        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        
        if ($vendor->authenticate($username, $password)) {
            $this->setVendorAsLoggedIn($vendor);
            return true;
        }
        return false;
    }

    public function setVendorAsLoggedIn($vendor)
    {
        $this->setVendor($vendor);
        $this->renewSession();
        Mage::getSingleton('core/session')->renewFormKey();
        Mage::dispatchEvent('vendor_login', array('vendor'=>$vendor));
        return $this;
    }

    public function setVendor(Ccc_Vendor_Model_Vendor $vendor)
    {
        $this->_vendor = $vendor;
        $this->setId($vendor->getId());
        return $this;
    }

    public function renewSession(){
        parent::renewSession();
        Mage::getSingleton('core/session')->unsSessionHosts();

        return $this;
    }

    public function getVendor()
    {
        if ($this->_vendor instanceof Ccc_Vendor_Model_Vendor) {
            return $this->_vendor;
        }

        $vendor = Mage::getModel('vendor/vendor');
        if ($this->getId()) {
            $vendor->load($this->getId());
        }
        $this->setVendor($vendor);
        return $this->_vendor;
    }

    public function logout()
    {
        if ($this->isLoggedIn()) {
            Mage::dispatchEvent('vendor_logout', array('vendor' => $this->getCustomer()) );
            $this->_logout();
        }
        return $this;
    }

    protected function _logout()
    {
        $this->setId(null);
        $this->setVendorGroupId(0);
        $this->getCookie()->delete($this->getSessionName());
        Mage::getSingleton('core/session')->renewFormKey();
        return $this;
    }

    public function getCookie(){
        return Mage::getSingleton('core/cookie');
    }
}

?>