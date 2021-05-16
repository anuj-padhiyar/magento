<?php 

class Ccc_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('vendorId');  //Id of Div tag which contains grid table
		$this->setDefaultSort('lastname');  //which?
		$this->setDeafultDir('DESC');
		$this->setSaveParametersInSession(true);  //Not Required
		//$this->setUseAjax(true);
		//$this->setVarNameFilter('vendor_filter');
	}

    // protected function _getStore()
    // {
    //     $storeId = (int) $this->getRequest()->getParam('store', 0);
    //     return Mage::app()->getStore($storeId);
    // }

    protected function _prepareCollection()
    {
        // $store = $this->_getStore();
        $collection = Mage::getModel('vendor/vendor')->getCollection();
            // ->addAttributeToSelect('firstname')
            // ->addAttributeToSelect('lastname')
            // ->addAttributeToSelect('email')
            // ->addAttributeToSelect('phoneNo')
            // ->addAttributeToSelect('hello');

        
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $collection
            ->joinAttribute( 
                'firstname',
                'vendor/firstname',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute(
                'lastname',
                'vendor/lastname',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute(
                'middlename',
                'vendor/middlename',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute(
                'password_hash',
                'vendor/password_hash',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute(
                'email',
                'vendor/email',
                'entity_id',
                null,
                'inner',
                $adminStore
            )
            ->joinAttribute(
                'id',
                'vendor/entity_id',
                'entity_id',
                null,
                'inner',
                $adminStore
            );

        // echo "<pre>";
        // print_r($collection->getData());
        // die;
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

	protected function _prepareColumns()
    {
        $this->addColumn('id',
                array(
                    'header' => Mage::helper('vendor')->__('Id'),
                    'width'  => '50px',
                    'index'  => 'id',
                ))
            ->addColumn('firstname',
                array(
                    'header' => Mage::helper('vendor')->__('First Name'),
                    'width'  => '50px',
                    'index'  => 'firstname',
                ))
            ->addColumn('middlename',
                array(
                    'header' => Mage::helper('vendor')->__('Middle Name'),
                    'width'  => '50px',
                    'index'  => 'middlename',
                ))
            ->addColumn('lastname',
                array(
                    'header' => Mage::helper('vendor')->__('Last Name'),
                    'width'  => '50px',
                    'index'  => 'lastname',
                ))
            ->addColumn('email',
                array(
                    'header' => Mage::helper('vendor')->__('Email'),
                    'width'  => '50px',
                    'index'  => 'email',
                ))
            ->addColumn('password',
                array(
                    'header' => Mage::helper('vendor')->__('Password Hash'),
                    'width'  => '50px',
                    'index'  => 'password_hash',
                ))
            ->addColumn('action',
                array(
                    'header'   => Mage::helper('vendor')->__('Action'),
                    'width'    => '50px',
                    'type'     => 'action',
                    'getter'   => 'getId',
                    'actions'  => array(
                        array(
                            'caption' => Mage::helper('vendor')->__('Delete'),
                            'url'     => array(
                                'base' => '*/*/delete',
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

    // public function getGridUrl(){
    //     return $this->getUrl('*/*/index', array('_current' => true));
    // }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            // 'store' => $this->getRequest()->getParam('store'),
            'id'=> $row->getId())
        );
    }
}

?>