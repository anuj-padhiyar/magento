<?php 

$installer = $this;

$installer->startSetup();
$installer->getConnection()->addKey($installer->getTable('vendor/vendor_datetime'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('vendor/vendor_int'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('vendor/vendor_text'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>