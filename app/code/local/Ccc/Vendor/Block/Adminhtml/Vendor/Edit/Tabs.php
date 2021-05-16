<?php 

class Ccc_Vendor_Block_Adminhtml_Vendor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{  
        parent::__construct();
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('vendor')->__('Vendor Information'));
	}

	// public function getVendor(){
    //     return Mage::registry('current_vendor');
    // }
    
    protected function _beforeToHtml()
    {
        // $setModel = Mage::getModel('eav/entity_attribute_set');

        // if (!($setId = $vendor->getAttributeSetId())) {
        //     $setId = $this->getRequest()->getParam('set', null);
        // }

        $vendor = Mage::registry('current_vendor');
        $vendorAttributes = Mage::getResourceModel('vendor/vendor_attribute_collection');
        if (!$vendor->getId()) {
            foreach ($vendorAttributes as $attribute) {
                $default = $attribute->getDefaultValue();
                if ($default != '') {
                    $vendor->setData($attribute->getAttributeCode(), $default);
                }
            }
        }

        $attributeSetId = $vendor->getResource()->getEntityType()->getDefaultAttributeSetId();
        $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->setAttributeSetFilter($attributeSetId)
            ->setSortOrder()
            ->load();

        $defaultGroupId = 0;
        foreach ($groupCollection as $group) {
            if ($defaultGroupId == 0 or $group->getIsDefault()) {
                $defaultGroupId = $group->getId();
            }

        }	

        foreach ($groupCollection as $group) {
            $attributes = array();
            foreach ($vendorAttributes as $attribute) {
                if ($vendor->checkInGroup($attribute->getId(),$attributeSetId, $group->getId())) {
                    $attributes[] = $attribute;
                }
            }

            if (!$attributes) {
                continue;
            }

            $active = $defaultGroupId == $group->getId();
            $block = $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_attributes')
                ->setGroup($group)
                ->setAttributes($attributes)
                ->setAddHiddenFields($active)
                ->toHtml();
            $this->addTab('group_' . $group->getId(), array(
                'label'     => Mage::helper('vendor')->__($group->getAttributeGroupName()),
                'content'   => $block,
                'active'    => $active
            ));
        }
      return parent::_beforeToHtml();
    }

    // protected function _translateHtml($html){
    //     Mage::getSingleton('core/translate_inline')->processResponseBody($html);
    //     return $html;
    // }
}

?>