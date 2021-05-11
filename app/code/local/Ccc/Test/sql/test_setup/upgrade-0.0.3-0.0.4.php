<?php 

$installer = $this;

$installer->startSetup();
$installer->getConnection()->addKey($installer->getTable('test/test_decimal'),
    'UNQ_TEST_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>