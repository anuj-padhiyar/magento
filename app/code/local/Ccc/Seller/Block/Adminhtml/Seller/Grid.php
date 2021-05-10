<?php 

class Ccc_Seller_Block_Adminhtml_Seller_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('sellerGrid');
		$this->setDefaultSort('seller_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('ccc_seller/data')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('seller_id',array(
			'header' => Mage::helper('seller')->__('ID'),
			'align' => 'right',
			'width' => '50px',
			'index'=> 'seller_id'
		));

		$this->addColumn('name',array(
			'header' => Mage::helper('seller')->__('Name'),
			'align' => 'left',
			'index'=> 'name'
		));

		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit',array('id' => $row->getId()));
	}
}

?>