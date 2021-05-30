<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct(){
        parent::__construct();
    }

    public function _prepareCollection(){
        $productCollection = Mage::getModel('catalog/product')->getCollection()
                                ->addAttributeToSelect('name','inner')
                                ->addAttributeToSelect('price','inner');
        $this->setCollection($productCollection);
        return parent::_prepareCollection();
    }

    public function _prepareColumns(){
        $this->addColumn('entity_id',array(
            'header'=>'ID',
            'index'=>'entity_id'
        ));
        $this->addColumn('name',array(
            'header'=>'Product Name',
            'index'=>'name'
        ));
        $this->addColumn('sku',array(
            'header'=>'SKU',
            'index'=>'sku'
        ));
        $this->addColumn('price',array(
            'header'=>'Price',
            'index'=>'price'
        ));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('add_to_cart', array(
             'label'=> Mage::helper('order')->__('Add To Cart'),
             'url'  => $this->getUrl('*/adminhtml_order/addProduct'),
             'confirm' => Mage::helper('order')->__('Are you sure?')
        ));
        return $this;
    }
}

?>