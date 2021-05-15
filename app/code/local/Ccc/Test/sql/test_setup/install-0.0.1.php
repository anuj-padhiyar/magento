<?php 

$this->startSetup();

$this->addEntityType(Ccc_Test_Model_Resource_Test::ENTITY,[
	'entity_model'=>'test/test',
	'attribute_model'=>'test/attribute',
	'table'=>'test/test',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'test/eav_attribute',
	'entity_attribute_collection' => 'test/test_attribute_collection'
]);

$this->createEntityTables('test');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('test', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'test'");

$this->endSetup();

?>