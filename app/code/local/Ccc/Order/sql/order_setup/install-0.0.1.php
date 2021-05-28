<?php

$this->startSetup();
$table = $this->getConnection()->newTable($this->getTable('order/cart'))
    ->addColumn(
        'cart_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'Cart Id'
    )
    ->addColumn(
        'customer_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Customer Id'
    )
    ->addColumn(
        'total',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default' => '0'),
        'Total'
    )
    ->addColumn(
        'discount',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default' => '0'),
        'Discount'
    )
    ->addColumn(
        'quantity',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false, 'default' => '0'),
        'Quantity'
    )
    ->addColumn(
        'customer_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => false),
        'Customer Name'
    )
    ->addColumn(
        'shipping_amount',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default' => '0'),
        'Shipping Amount'
    )
    ->addColumn(
        'shipping_method_code',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        64,
        array('nullable' => true, 'default' => null),
        'Shipping Method Code'
    )
    ->addColumn(
        'payment_method_code',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        64,
        array('nullable' => true, 'default' => null),
        'Payment Method Code'
    )
    ->addColumn(
        'comment',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => true, 'default' => null),
        'Comment'
    )
    ->addColumn(
        'created_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        10,
        array('nullable' => false),
        'Created Date'
    );
$this->getConnection()->createTable($table);


$table = $this->getConnection()->newTable($this->getTable('order/cart_item'))
    ->addColumn(
        'item_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'Item Id'
    )
    ->addColumn(
        'cart_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Cart Id'
    )
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Product Id'
    )
    ->addColumn(
        'quantity',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false, 'default' => '1'),
        'Quantity'
    )
    ->addColumn(
        'base_price',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false),
        'Base Price'
    )
    ->addColumn(
        'price',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false),
        'Price'
    )
    ->addColumn(
        'discount',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default'=>'0'),
        'Discount'
    )
    ->addColumn(
        'created_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        10,
        array('nullable' => false),
        'Created Date'
    );
$this->getConnection()->createTable($table);

$table = $this->getConnection()->newTable($this->getTable('order/cart_address'))
    ->addColumn(
        'address_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'Address Id'
    )
    ->addColumn(
        'cart_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Cart Id'
    )
    ->addColumn(
        'address_type',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        32,
        array('nullable' => false),
        'Address Type'
    )
    ->addColumn(
        'address',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'Address'
    )
    ->addColumn(
        'city',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'City'
    )
    ->addColumn(
        'state',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'State'
    )
    ->addColumn(
        'country',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'Country'
    )
    ->addColumn(
        'zipcode',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'Zipcode'
    )
    ->addColumn(
        'same_as_billing',
        Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        2,
        array('nullable' => false , 'default' => '0'),
        'Same As Billing'
    )
    ->addColumn(
        'created_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        10,
        array('nullable' => false),
        'Created Date'
    );
$this->getConnection()->createTable($table);


$table = $this->getConnection()->newTable($this->getTable('order/order'))
    ->addColumn(
        'order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'order Id'
    )
    ->addColumn(
        'customer_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Customer Id'
    )
    ->addColumn(
        'total',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default' => '0'),
        'Total'
    )
    ->addColumn(
        'discount',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default' => '0'),
        'Discount'
    )
    ->addColumn(
        'quantity',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false, 'default' => '0'),
        'Quantity'
    )
    ->addColumn(
        'customer_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => false),
        'Customer Name'
    )
    ->addColumn(
        'shipping_amount',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false, 'default' => '0'),
        'Shipping Amount'
    )
    ->addColumn(
        'shipping_method_code',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        64,
        array('nullable' => true, 'default' => null),
        'Shipping Method Code'
    )
    ->addColumn(
        'payment_method_code',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        64,
        array('nullable' => true, 'default' => null),
        'Payment Method Code'
    )
    ->addColumn(
        'comment',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => true, 'default' => null),
        'Comment'
    )
    ->addColumn(
        'created_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        10,
        array('nullable' => false),
        'Created Date'
    );
$this->getConnection()->createTable($table);


$table = $this->getConnection()->newTable($this->getTable('order/order_item'))
    ->addColumn(
        'item_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'Item Id'
    )
    ->addColumn(
        'order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'order Id'
    )
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Product Id'
    )
    ->addColumn(
        'quantity',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false, 'default' => '1'),
        'Quantity'
    )
    ->addColumn(
        'base_price',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false),
        'Base Price'
    )
    ->addColumn(
        'price',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false),
        'Price'
    )
    ->addColumn(
        'discount',
        Varien_Db_Ddl_Table::TYPE_FLOAT,
        32,
        array('nullable' => false ,'default'=>'0'),
        'Discount'
    )
    ->addColumn(
        'created_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        10,
        array('nullable' => false),
        'Created Date'
    );
$this->getConnection()->createTable($table);

$table = $this->getConnection()->newTable($this->getTable('order/order_address'))
    ->addColumn(
        'address_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'Address Id'
    )
    ->addColumn(
        'order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => false),
        'Order Id'
    )
    ->addColumn(
        'address_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        10,
        array('nullable' => true , 'default' => null),
        'Address Id'
    )
    ->addColumn(
        'address_type',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        32,
        array('nullable' => false),
        'Address Type'
    )
    ->addColumn(
        'address',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'Address'
    )
    ->addColumn(
        'city',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'City'
    )
    ->addColumn(
        'state',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'State'
    )
    ->addColumn(
        'country',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'Country'
    )
    ->addColumn(
        'zipcode',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        128,
        array('nullable' => false),
        'Zipcode'
    )
    ->addColumn(
        'same_as_billing',
        Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        2,
        array('nullable' => false , 'default' => '0'),
        'Same As Billing'
    )
    ->addColumn(
        'created_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        10,
        array('nullable' => false),
        'Created Date'
    );
$this->getConnection()->createTable($table);

$this->endSetup();
