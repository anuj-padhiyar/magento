<?php

class Ccc_Vendor_Block_Account_Product_Attribute_Edit extends Mage_Core_Block_Template{
    public function __construct(){
        $this->_objectId = 'attribute_id';
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_product_attribute';
        parent::__construct();
    }

    public function getHeaderText(){
        if(Mage::registry('product_attribute')->getId()) {
            return Mage::helper('vendor')->__('Edit Product Attribute');
        }else{
            return Mage::helper('vendor')->__('New Product Attribute');
        }
    }

    public function getSaveUrl(){
        return $this->getUrl('*/'.$this->_controller.'/save', array('_current'=>true, 'back'=>null));
    }

    public function getValue($key,$attr){
        if($attr->$key){
            return $attr->$key;
        }
        return null;
    }   

    public function getGroups(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        return Mage::getResourceModel('vendor/product_attribute_group_collection')->addFieldToFilter('vendor_id',['like'=>$vendorId]);
    }

    public function getCurrentGroup(){
        if($attributeId = $this->getRequest()->getParam('id')){
            $setId = Mage::getModel('eav/entity_setup', 'core_setup')->getAttributeSetId('vendor_product', 'Default');
            $readConnnection = Mage::getSingleton('core/resource')->getConnection('core_read');
            $id = $readConnnection 
                    ->fetchRow(
                            "SELECT attribute_group_id 
                            FROM eav_entity_attribute 
                            WHERE attribute_id = $attributeId 
                            AND attribute_set_id = $setId");
            return $id['attribute_group_id'];
        }
        return null;
    }

    public function getAddNewButtonHtml(){
        return $this->getChildHtml('add_button');
    }

    public function getOptions($id){
        $options = Mage::getModel('eav/entity_attribute')->getCollection();
        $options->join(
                ['main'=>'attribute_option'],'main_table.attribute_id = main.attribute_id',
                ['option_id'=>'main.option_id','sort_order'=>'main.sort_order'])
                ->addFieldToFilter('main_table.attribute_id',['eq'=>$id])
                ->setOrder('main.sort_order','asc');

        $options->join(['option_value'=>'eav/attribute_option_value'],'main.option_id = option_value.option_id',
             ['value'=>'option_value.value','store_id'=>'option_value.store_id']);

        return $options->getData();        
    }

    public function getOptionValues($id)
    {
        $inputType = 'radio';
        $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                            ->setAttributeFilter($id)
                            ->setPositionOrder('desc', true)
                            ->load();
                
        $defaultValues = array();
        foreach ($optionCollection as $option) {
            $value = array();
            if (in_array($option->getId(), $defaultValues)) {
                $value['checked'] = 'checked="checked"';
            } else {
                $value['checked'] = '';
            }

            $value['intype'] = $inputType;
            $value['id'] = $option->getId();
            $value['sort_order'] = $option->getSortOrder();

            $options = $this->getOptions($option->attribute_id);
            $stores = $this->getStores($options,$option->option_id);
            $value = array_merge($value, $stores);
            
            if($this->getDefaultValue($options,$option->option_id)){
                $value['checked'] = 'checked="checked"';
            }else{
                $value['checked'] = '';
            }

            $values[] = new Varien_Object($value);
        }
        $this->setData('option_values', $values);
        return $values;
    }

    
    public function getDefaultValue($data,$optionId)
    {
        if($data){
            foreach($data as $key=>$value){
                if($value['default_value'] == $optionId){
                    return true;
                }
            }
        }
        return false;
    }

    public function getStores($data,$optionId)
    {
        $stores = [];
        if($data){
            foreach($data as $key=>$value){
                if($value['option_id'] == $optionId){
                    $stores['store'.$value['store_id']] = $value['value'];
                }
            }
        }
        return $stores;
    }

}
?>