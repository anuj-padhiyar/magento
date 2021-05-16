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
}

?>