<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'vendor/product'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('vendor/product'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute Set ID')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable'  => false,
        'default'   => Mage_Catalog_Model_Product_Type::DEFAULT_TYPE,
        ), 'Type ID')
    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        ), 'SKU')
    ->addColumn('has_options', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Has Options')
    ->addColumn('required_options', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Required Options')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Update Time')
    ->addIndex($installer->getIdxName('vendor/product', array('entity_type_id')),
        array('entity_type_id'))
    ->addIndex($installer->getIdxName('vendor/product', array('attribute_set_id')),
        array('attribute_set_id'))
    ->addIndex($installer->getIdxName('vendor/product', array('sku')),
        array('sku'))
    ->addForeignKey(
        $installer->getFkName(
            'vendor/product',
            'attribute_set_id',
            'eav/attribute_set',
            'attribute_set_id'
        ),
        'attribute_set_id', $installer->getTable('eav/attribute_set'), 'attribute_set_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('vendor/product', 'entity_type_id', 'eav/entity_type', 'entity_type_id'),
        'entity_type_id', $installer->getTable('eav/entity_type'), 'entity_type_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Table');
$installer->getConnection()->createTable($table);



/**
 * Create table array('vendor/product', 'datetime')
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable(array('vendor/product', 'datetime')))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity ID')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            array('vendor/product', 'datetime'),
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName(array('vendor/product', 'datetime'), array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'datetime'), array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'datetime'), array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'datetime'),
            'attribute_id',
            'eav/attribute',
            'attribute_id'
         ),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'datetime'),
            'entity_id',
            'vendor/product',
            'entity_id'
        ),
        'entity_id', $installer->getTable('vendor/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'datetime'),
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Datetime Attribute Backend Table');
$installer->getConnection()->createTable($table);

/**
 * Create table array('vendor/product', 'decimal')
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable(array('vendor/product', 'decimal')))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity ID')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            array('vendor/product', 'decimal'),
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName(array('vendor/product', 'decimal'), array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'decimal'), array('entity_id')),
        array('entity_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'decimal'), array('attribute_id')),
        array('attribute_id'))
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'decimal'),
            'attribute_id',
            'eav/attribute',
            'attribute_id'
        ),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'decimal'),
            'entity_id',
            'vendor/product',
            'entity_id'
        ),
        'entity_id', $installer->getTable('vendor/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName(array('vendor/product', 'decimal'), 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Decimal Attribute Backend Table');
$installer->getConnection()->createTable($table);

/**
 * Create table array('vendor/product', 'int')
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable(array('vendor/product', 'int')))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity ID')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            array('vendor/product', 'int'),
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName(array('vendor/product', 'int'), array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'int'), array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'int'), array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'int'),
            'attribute_id',
            'eav/attribute',
            'attribute_id'
        ),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'int'),
            'entity_id',
            'vendor/product',
            'entity_id'
        ),
        'entity_id', $installer->getTable('vendor/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            array('vendor/product', 'int'),
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Integer Attribute Backend Table');
$installer->getConnection()->createTable($table);

/**
 * Create table array('vendor/product', 'text')
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable(array('vendor/product', 'text')))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity ID')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            array('vendor/product', 'text'),
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName(array('vendor/product', 'text'), array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'text'), array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'text'), array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'text'), 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'text'), 'entity_id', 'vendor/product', 'entity_id'),
        'entity_id', $installer->getTable('vendor/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName(array('vendor/product', 'text'), 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Text Attribute Backend Table');
$installer->getConnection()->createTable($table);

/**
 * Create table array('vendor/product', 'varchar')
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable(array('vendor/product', 'varchar')))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity ID')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            array('vendor/product', 'varchar'),
            array('entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName(array('vendor/product', 'varchar'), array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'varchar'), array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'varchar'), array('entity_id')),
        array('entity_id'))
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'varchar'), 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'varchar'), 'entity_id', 'vendor/product', 'entity_id'),
        'entity_id', $installer->getTable('vendor/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'varchar'), 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Varchar Attribute Backend Table');
$installer->getConnection()->createTable($table);

/**
 * Create table array('vendor/product', 'gallery')
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable(array('vendor/product', 'gallery')))
    ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Value ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store ID')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Position')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        'default'   => null,
        ), 'Value')
    ->addIndex(
        $installer->getIdxName(
            array('vendor/product', 'gallery'),
            array('entity_type_id', 'entity_id', 'attribute_id', 'store_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('entity_type_id', 'entity_id', 'attribute_id', 'store_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName(array('vendor/product', 'gallery'), array('entity_id')),
        array('entity_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'gallery'), array('attribute_id')),
        array('attribute_id'))
    ->addIndex($installer->getIdxName(array('vendor/product', 'gallery'), array('store_id')),
        array('store_id'))
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'gallery'), 'attribute_id', 'eav/attribute', 'attribute_id'),
        'attribute_id', $installer->getTable('eav/attribute'), 'attribute_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'gallery'), 'entity_id', 'vendor/product', 'entity_id'),
        'entity_id', $installer->getTable('vendor/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(array('vendor/product', 'gallery'), 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Catalog Product Gallery Attribute Backend Table');
$installer->getConnection()->createTable($table);

$installer->getConnection()->addColumn($installer->getTable('core/url_rewrite'), 'product_id', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned'  => true,
    'nullable'  => true,
    'comment'   => 'Product Id'
));
$installer->installEntities();
$installer->endSetup();

