<?php 

class Ccc_Vendor_Block_Account_Product_Edit_Tabs_Attributes extends Mage_Core_Block_Template
{
	protected $group = [];
	protected $attributes = [];
	public function __construct(){
		$this->setTemplate('vendor/account/product/edit/tabs/attribute.phtml');
	}

	public function getVendorproductdata(){
		$vendorId = Mage::getModel('vendor/session')->getId();
    	$product =  Mage::registry('current_product');
		$product->sku = str_replace($vendorId.'_','', $product->sku);
		return $product;
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
}

?>