<?php 

class Ccc_Vendor_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct(){
        parent::__construct();
        $this->setId('productId');
        $this->setSaveParametersInSession(true);
    }

    public function _prepareCollection(){
        $collection = Mage::getResourceModel('vendor/product_request_collection');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns(){
        $this->addColumn('product_id',
                array(
                    'header' => Mage::helper('vendor')->__('Product ID'),
                    'index' => 'product_id'
                ))
            ->addColumn('request_type',
                array(
                    'header' => Mage::helper('vendor')->__('Request Type'),
                    'index'  => 'request_type',
                ))
            ->addColumn('catalog_product_id',
                array(
                    'header' => Mage::helper('vendor')->__('Catalog Product Id'),
                    'index' => 'catalog_product_id'
                ))
            ->addColumn('request_status',
                array(
                    'header' => Mage::helper('vendor')->__('Request Status'),
                    'index' => 'request_status'
                ))
            ->addColumn('action',
                array(
                    'header'   => Mage::helper('vendor')->__('Action'),
                    'width'    => '50px',
                    'type'     => 'action',
                    'getter'   => 'getId',
                    'actions'  => array(
                        array(
                            'caption' => Mage::helper('vendor')->__('Accept'),
                            'url'     => array(
                                'base' => '*/*/accept',
                            ),
                            'field'   => 'id',
                        ),
                        array(
                            'caption' => Mage::helper('vendor')->__('Reject'),
                            'url'     => array(
                                'base' => '*/*/reject',
                            ),
                            'field'   => 'id',
                        )
                    ),
                    'filter'   => false,
                    'sortable' => false,
                ));
        parent::_prepareColumns();
        return $this;
    }

    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id'=> $row->getId()));
    }
}

?>