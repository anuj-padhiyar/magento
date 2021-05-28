<?php 

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE {$installer->getTable('order/cart_address')} ADD first_name varchar(64);");
$installer->run("ALTER TABLE {$installer->getTable('order/cart_address')} ADD last_name varchar(64);");
$installer->run("ALTER TABLE {$installer->getTable('order/order_address')} ADD first_name varchar(64);");
$installer->run("ALTER TABLE {$installer->getTable('order/order_address')} ADD last_name varchar(64);");
$installer->endSetup();

?>