<?php
class Ccc_Test_Block_Adminhtml_Test_Edit_Tab_Setting extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout()
    {
       $this->setChild('continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('test')->__('Continue'),
                    'onclick'   => "setSettings('".$this->getContinueUrl()."','attribute_set_id',null)",
                    'class'     => 'save'
                    ))
                );
        return parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('settings', array('legend'=>Mage::helper('test')->__('Create Test Settings')));

        $entityType = Mage::registry('current_test')->getResource()->getEntityType();

        $fieldset->addField('attribute_set_id', 'select', array(
            'label' => Mage::helper('test')->__('Attribute Set'),
            'title' => Mage::helper('test')->__('Attribute Set'),
            'name'  => 'set',
            'value' => $entityType->getDefaultAttributeSetId(),
            'values'=> Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter($entityType->getId())
                ->load()
                ->toOptionArray()
        ));

        $fieldset->addField('continue_button', 'note', array(
            'text' => $this->getChildHtml('continue_button'),
        ));

        $this->setForm($form);
    }

    public function getContinueUrl()
    {
        return $this->getUrl('*/*/new', array(
            '_current'  => true,
            'set'       => '{{attribute_set}}',
            'type'      => '{{type}}'
        ));
    }
}
?>

<script type="text/javascript">
    var productTemplateSyntax = /(^|.|\r|\n)({{(\w+)}})/;
    function setSettings(urlTemplate, setElement) {
        var template = new Template(urlTemplate, productTemplateSyntax);
        setLocation(template.evaluate({attribute_set:$F(setElement)}));
    }
</script>