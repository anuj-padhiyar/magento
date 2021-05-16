<?php 

class Ccc_Vendor_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct(){
        parent::__construct();
		$this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_product';
		$this->_headerText = 'Add Vendor';
		$this->_removeButton('reset');
		$this->_removeButton('save');
		$this->_removeButton('delete');
		$data = array(
			'label' =>  'Approve',
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/approve',['_current'=>true]) . '\')',
			'class'     =>  'save'
	   );
		$this->addButton ('approve', $data, 1, 0,  'header'); 
		$data = array(
			'label' =>  'Reject',
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/reject',['_current'=>true]) . '\')',
			'class'     =>  'delete'
	   );
		$this->addButton ('reject', $data, 1, 0,  'header'); 
	}
}

?>