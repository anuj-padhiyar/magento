<?php 

$installer = $this;

$installer->startSetup();
$installer->getConnection()->addKey($installer->getTable('vendor/vendor_decimal'),
    'UNQ_MEET_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>