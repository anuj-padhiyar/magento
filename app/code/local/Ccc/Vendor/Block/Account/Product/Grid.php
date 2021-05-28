<?php 

class Ccc_Vendor_Block_Account_Product_Grid extends Mage_Core_Block_Template{	
    protected $requests = [];
	protected function _prepareCollection(){
        $vendorId = Mage::getModel('vendor/session')->getId();
        $collection =  Mage::getResourceModel('vendor/product_collection');
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection
            ->joinAttribute( 
                'sku',
                'vendor_product/sku',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute( 
                'name',
                'vendor_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute( 
                'price',
                'vendor_product/price',
                'entity_id',
                null,
                'inner',
                $adminStore
            );

        $collection->addFieldToFilter('sku',['like'=>$vendorId.'_%']);
        return $collection;
	}

    public function setRequests($request = null){
        if(!$request){
            $request = Mage::getModel('vendor/product_request')->getCollection();
        }
        $this->requests = $request;
        return $this;
    }

    public function getRequests(){
        if(!$this->requests){
            $this->setRequests();
        }
        return $this->requests;
    }

    public function getRequestById($id){
        $model = $this->getRequests();
        if($model){
            foreach(array_reverse($model->getData()) as $key=>$req){
                if($req['product_id'] == $id){return $req;}
            }
        }
    }
}