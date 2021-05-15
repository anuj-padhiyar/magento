<?php

class Ccc_Test_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_Test';

    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('test/attribute');
    }
}
