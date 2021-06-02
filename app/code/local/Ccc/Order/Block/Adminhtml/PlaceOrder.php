<?php 

class Ccc_Order_Block_Adminhtml_PlaceOrder extends Mage_Core_Block_Template{
    protected $status = [
        'Placed'=>'1',
        'Pending'=>'2',
        'Hold'=>'2',
        'Success'=>'3',
        'Failed'=>'3'
    ];

    public function __construct(){
        parent::__construct();
    }

    public function getOrder(){
        return Mage::getModel('order/order')->load($this->getRequest()->getParam('id'));
    }

    public function getCountry($code){
        $data = Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
        foreach($data as $key=>$value){
            if($value['value'] == $code){
                return $value['label'];
            }
        }
        return false;
    }

    public function getStatus(){
        return $this->status;
    }
}