<?php 

$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('vendor/product'),'store_id', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'nullable'  => false,
    'default'   => 0,
    'length'    => 255,
    'after'     => 'entity_id', // column name to insert new column after
    'comment'   => 'Store Id'
    ));   
$installer->endSetup();
?>