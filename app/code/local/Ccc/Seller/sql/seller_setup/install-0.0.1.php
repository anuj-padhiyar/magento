<?php 

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
			->newTable($installer->getTable('ccc_seller/data'))
			->addColumn('seller_id',
				Varien_Db_Ddl_Table::TYPE_INTEGER,null,
				array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				),'Id'
			)
			->addColumn('name',
				Varien_Db_Ddl_Table::TYPE_VARCHAR,null,
				array(
					'nullable' => false,
				),'Name'
			);

$installer->getConnection()->createTable($table);

$installer->endSetup();			
?>