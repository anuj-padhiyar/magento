<?php 

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
                    ->newTable($installer->getTable('vendor/productGroup'))
                    ->addColumn('group_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,10,[
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],'Group ID')
                    ->addColumn('vendor_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,null,['nullable' => false,'unsigned' => true,] ,'Entity Id')
                    ->addColumn('attribute_group_id',
                        Varien_Db_Ddl_Table::TYPE_SMALLINT,null,[
                            'nullable' => false,
                            'unsigned' => true
                        ],'Attribute Group Id')
                    ->addColumn('attribute_group_name',
                            Varien_Db_Ddl_Table::TYPE_VARCHAR,64,['nullable'=>false],'Attribute Group Name')
                    ->addForeignKey(
                            $installer->getFkName(
                                'vendor/productGroup',
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
                                'vendor/productGroup',
                                'attribute_group_id',
                                'eav/attribute_group',
                                'attribute_group_id'
                            ),
                            'attribute_group_id',
                            $installer->getTable('eav/attribute_group'),
                            'attribute_group_id',
                            Varien_Db_Ddl_Table::ACTION_CASCADE,
                            Varien_Db_Ddl_Table::ACTION_CASCADE
                        );
$installer->getConnection()->createTable($table);
$installer->endSetup();

?>