<?php 

$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('vendor/eav_attribute'),'sort_order', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'nullable'  => false,
    'length'    => 255,
    'after'     => null, // column name to insert new column after
    'comment'   => 'Sort Order'
    ));   
$installer->endSetup();
?>