<?php 

class Ccc_Vendor_Model_Resource_Product extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'vendor_product';
    public function _construct(){
        $this->setType('vendor_product')->setConnection('core_read', 'core_write');
	    parent::_construct();
    }
}

?>