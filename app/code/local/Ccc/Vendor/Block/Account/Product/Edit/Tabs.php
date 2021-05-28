<?php 

class Ccc_Vendor_Block_Account_Product_Edit_Tabs extends Mage_Core_Block_Template{

    protected $tabs = [];
    protected $defaultGroup = 0;

    public function addTab($key, $tab = []){
        $this->tabs[$key] = $tab;
        return $this;
    }

    public function getGroups(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        $product = Mage::registry('current_product');
        $productAttributes  = Mage::getResourceModel('vendor/product_attribute_collection')
                                ->addFieldToFilter('attribute_code',['like'=>$vendorId."%"]);

        $vendorProduct = Mage::getModel('vendor/product');
        $entityTypeId = $vendorProduct->getResource()->getEntityType()->getId();
        $attributeSetId = $vendorProduct->getResource()->getEntityType()->getDefaultAttributeSetId();
        
        $productAttributes2 = Mage::getResourceModel('eav/entity_attribute_collection');
		$productAttributes2->getSelect()
				->join(
					array('attribute'=> 'eav_entity_attribute'),
            		'attribute.attribute_id = main_table.attribute_id',
            		array('*'))
				->where("main_table.entity_type_id = {$entityTypeId} AND main_table.is_user_defined = 0 AND attribute.attribute_set_id = {$attributeSetId} AND main_table.is_required = 1");

        $productAttributes2->addFieldToFilter('frontend_label', array('neq' => NULL))
                            ->addFieldToFilter('attribute_code', array('nin' => ['image_label', 'small_image_label', 'thumbnail_label']));
        
        $productAttributes2 = $productAttributes2->load();
        $productAttributes = array_merge($productAttributes->getItems(),$productAttributes2->getItems());

        if (!$product->getId()) {
            foreach ($productAttributes as $attribute) {
                $default = $attribute->getDefaultValue();
                if ($default != '') {
                    $product->setData($attribute->getAttributeCode(), $default);
                }
            }
        }

        $attributeSetId = $product->getResource()->getEntityType()->getDefaultAttributeSetId();
        $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->setAttributeSetFilter($attributeSetId)
            ->addFieldToFilter('attribute_group_name',array('like'=>$vendorId.'_%'));
        $groupCollection1 = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->setAttributeSetFilter($attributeSetId)
            ->addFieldToFilter('attribute_group_name',array('regexp'=>'^[A-Z][a-z]'));
        $groupCollection = array_merge($groupCollection->getData(),$groupCollection1->getData());
        
        $defaultGroupId = 0;
        foreach ($groupCollection as $group) {
            if ($defaultGroupId == 0 || $group['is_default'] || $group['attribute_group_name'] == 'General') {
                $defaultGroupId = $group['attribute_group_id'];
            }

        }	

        foreach ($groupCollection as $group) {
            $attributes = array();
            foreach ($productAttributes as $attribute) {
                if ($product->checkInGroup($attribute->getId(),$attributeSetId, $group['attribute_group_id'])) {
                    $attributes[] = $attribute;
                }
            }

            if (!$attributes) {
                continue;
            }
            $active = $defaultGroupId == $group['attribute_group_id'];
            $this->setDefaultGroup($defaultGroupId);
            $block = $this->getLayout()->createBlock('vendor/account_product_edit_tabs_attributes')
                ->setGroup($group)
                ->setAttributes($attributes)
                ->setAddHiddenFields($active)
                ->toHtml();

            $this->addTab('group_' . $group['attribute_group_id'], array(
                'label'     => Mage::helper('vendor')->__($group['attribute_group_name']),
                'content'   => $block,
                'active'    => $active
            ));
        }
        return $this->tabs;
    }

    public function getDefaultGroup(){
        return $this->defaultGroup;
    }

    public function setDefaultGroup($id){
        $this->defaultGroup = $id;
        return $this;
    }
}