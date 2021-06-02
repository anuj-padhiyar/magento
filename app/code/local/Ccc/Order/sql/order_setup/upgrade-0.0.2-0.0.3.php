<?php

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()->newTable($installer->getTable('order/order_status'))
    ->addColumn(
        'status_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'Order Id'
    )
    ->addColumn(
        'order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false, 'unsigned' => true),
        'Order Id'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        32,
        array('nullable' => false),
        'Status'
    )
    ->addColumn(
        'comment',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => false),
        'Comment'
    )
    ->addColumn(
        'date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        '',
        array('nullable' => false),
        'Date'
    )
    ->addForeignKey(
        $installer->getFkName(
            'order/order_status',
            'order_id',
            'order/order',
            'order_id'
        ),
        'order_id',
        $installer->getTable('order/order'),
        'order_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );
$installer->getConnection()->createTable($table);
$installer->endSetup();