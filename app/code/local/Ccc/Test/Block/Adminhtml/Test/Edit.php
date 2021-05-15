<?php 

class Ccc_Test_Block_Adminhtml_Test_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'test';
        $this->_controller = 'adminhtml_test';
        $this->_headerText = 'Add Test';
        parent::__construct();
        
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}

?>