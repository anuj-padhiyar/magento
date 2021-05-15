<?php 

class Ccc_Test_Block_Adminhtml_Test_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('testId');
		$this->setDefaultSort('entity_Id');
		$this->setDeafultDir('DESC');
		$this->setSaveParametersInSession(true);
		//$this->setUseAjax(true);
		//$this->setVarNameFilter('test_filter');
	}

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        $store = $this->_getStore();        
        $collection = Mage::getModel('test/test')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('phoneNo');
            // ->addAttributeToSelect('price_attribute');

        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection->joinAttribute( /*test kapadiya #1*/
            'firstname',
            'test/firstname',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $collection->joinAttribute(
            'lastname',
            'test/lastname',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'email',
            'test/email',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'phoneNo',
            'test/phoneNo',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        $collection->joinAttribute(
            'id',
            'test/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );
        // $collection->joinAttribute(
        //     'price',
        //     'test/price_attribute',
        //     'entity_id',
        //     null,
        //     'inner',
        //     $adminStore
        // );

        $this->setCollection($collection);

        parent::_prepareCollection();
        
        return $this;
    }

	protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('test')->__('id'),
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('firstname',
            array(
                'header' => Mage::helper('test')->__('First Name'),
                'width'  => '50px',
                'index'  => 'firstname',
            ));

        $this->addColumn('lastname',
            array(
                'header' => Mage::helper('test')->__('Last Name'),
                'width'  => '50px',
                'index'  => 'lastname',
            ));

        $this->addColumn('email',
            array(
                'header' => Mage::helper('test')->__('Email'),
                'width'  => '50px',
                'index'  => 'email',
            ));

        $this->addColumn('phoneNo',
            array(
                'header' => Mage::helper('test')->__('Phone Number'),
                'width'  => '50px',
                'index'  => 'phoneNo',
            ));
        $this->addColumn('action',
            array(
                'header'   => Mage::helper('test')->__('Action'),
                'width'    => '50px',
                'type'     => 'action',
                'getter'   => 'getId',
                'actions'  => array(
                    array(
                        'caption' => Mage::helper('test')->__('Delete'),
                        'url'     => array(
                            'base' => '*/*/delete',
                        ),
                        'field'   => 'id',
                    ),
                ),
                'filter'   => false,
                'sortable' => false,
            ));

        parent::_prepareColumns();
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/index', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'store' => $this->getRequest()->getParam('store'),
            'id'    => $row->getId())
        );
    }
}

?>