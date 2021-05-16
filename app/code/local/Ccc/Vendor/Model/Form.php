<?php 
class Ccc_Vendor_Model_Form extends Mage_Eav_Model_Form
{

    protected $_moduleName = 'vendor';
    protected $_entityTypeCode = 'vendor';

    /**
     * Get EAV Entity Form Attribute Collection for Customer
     * exclude 'created_at'
     *
     * @return Mage_Customer_Model_Resource_Form_Attribute_Collection
     */
    protected function _getFormAttributeCollection(){   
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}
