<?php 

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->removeAttribute(Ccc_Test_Model_Resource_Test::ENTITY,'phoneNo');

$setup->addAttribute(Ccc_Test_Model_Resource_Test::ENTITY, 'phoneNo', array(
    'group'                      => 'General',
    'input'                      => 'text',
    'type'                       => 'varchar',
    'label'                      => 'phoneNo',
    'frontend_class'             => 'validate-digits',
    'backend'                    => '',
    'visible'                    => 1,
    'required'                   => 0,
    'user_defined'               => 1,
    'searchable'                 => 1,
    'filterable'                 => 0,
    'comparable'                 => 1,
    'visible_on_front'           => 1,
    'visible_in_advanced_search' => 0,
    'is_html_allowed_on_front'   => 1,
    'global'                     => Ccc_Test_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$installer->endSetup();
?>