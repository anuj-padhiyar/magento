<?php 

$installer = $this;

$installer->startSetup();
$installer->getConnection()->addKey($installer->getTable('test/test_datetime'),
    'UNQ_Test_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('test/test_int'),
    'UNQ_Test_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('test/test_text'),
    'UNQ_Test_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>