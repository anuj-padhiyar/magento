<?php 

class Ccc_Test_Model_Resource_Test extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'test';
	
	public function __construct()
	{

		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');

	   parent::__construct();
    }
}

?>