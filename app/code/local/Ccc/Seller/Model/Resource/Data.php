<?php 

class Ccc_Seller_Model_Resource_Data extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('ccc_seller/data','seller_id');
	}
}
