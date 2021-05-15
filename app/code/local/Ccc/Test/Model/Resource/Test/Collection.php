<?php
class Ccc_Test_Model_Resource_Test_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('test');
		parent::__construct();
		
	}
}