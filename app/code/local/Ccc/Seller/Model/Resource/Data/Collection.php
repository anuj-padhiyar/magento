<?php 

class Ccc_Seller_Model_Resource_Data_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	public function _construct()
	{
		// parent::_construct();
		$this->_init('ccc_seller/data');
	}
}
?>