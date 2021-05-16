<?php 

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
                    ->newTable($installer->getTable('vendor/request'))
                    ->addColumn('request_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,10,[
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],'Request Id')
                    ->addColumn('vendor_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,10,[
                            'nullable' => false,
                            'unsigned' => true,
                        ] ,'Vendor Id')
                    ->addColumn('product_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,10,[
                            'nullable' => false,
                            'unsigned' => true
                        ],'Product Id')
                    ->addColumn('catalog_product_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,10,[
                            'nullable' => true,
                            'unsigned' => true,
                            'default' => null
                        ],'Catalog Product Id')
                    ->addColumn('request_type',
                        Varien_Db_Ddl_Table::TYPE_TEXT,null,[
                            'nullable' => false,
                            'unsigned' => false
                        ],'Request Type')
                    ->addColumn('request_status',
                        Varien_Db_Ddl_Table::TYPE_TEXT,null,[
                            'nullable' => false,
                            'unsigned' => false
                        ],'Request Status')
                    ->addColumn('request_date',
                        Varien_Db_Ddl_Table::TYPE_DATETIME,null,[
                            'nullable' => true,
                            'unsigned' => false,
                            'default' => null
                        ],'Request Date')
                    ->addColumn('request_approved_date',
                        Varien_Db_Ddl_Table::TYPE_DATETIME,null,[
                            'nullable' => true,
                            'unsigned' => false,
                            'default' => null
                        ],'Request Approved Data')
                    ->addForeignKey(
                            $installer->getFkName(
                                'vendor/request',
                                'vendor_id',
                                'vendor/vendor',
                                'entity_id'
                            ),
                            'vendor_id',
                            $installer->getTable('vendor/vendor'),
                            'entity_id',
                            Varien_Db_Ddl_Table::ACTION_CASCADE,
                            Varien_Db_Ddl_Table::ACTION_CASCADE
                        )
                    ->addForeignKey(
                            $installer->getFkName(
                                'vendor/request',
                                'product_id',
                                'vendor/product',
                                'entity_id'
                            ),
                            'product_id',
                            $installer->getTable('vendor/product'),
                            'entity_id',
                            Varien_Db_Ddl_Table::ACTION_CASCADE,
                            Varien_Db_Ddl_Table::ACTION_CASCADE
                        )
                    ->addForeignKey(
                            $installer->getFkName(
                                'vendor/request',
                                'catalog_product_id',
                                'catalog/product',
                                'entity_id'
                            ),
                            'catalog_product_id',
                            $installer->getTable('catalog/product'),
                            'entity_id',
                            Varien_Db_Ddl_Table::ACTION_CASCADE,
                            Varien_Db_Ddl_Table::ACTION_CASCADE
                        );
$installer->getConnection()->createTable($table);
$installer->endSetup();
?>

