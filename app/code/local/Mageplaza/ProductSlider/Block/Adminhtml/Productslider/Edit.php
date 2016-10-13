<?php

class Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    const PAGE_TABS_BLOCK_ID = 'productslider_tabs';

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'productslider';
        $this->_controller = 'adminhtml_productslider';

        $this->_updateButton('save', 'label', Mage::helper('productslider')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productslider')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productslider_content') == null)
                    tinyMCE.execCommand('mceAddControl', false, 'productslider_content');
                else
                    tinyMCE.execCommand('mceRemoveControl', false, 'productslider_content');
            }

            function saveAndContinueEdit(urlTemplate){
                var urlTemplateSyntax = /(^|.|\\r|\\n)({{(\\w+)}})/;
                var template = new Template(urlTemplate, urlTemplateSyntax);
                var url = template.evaluate({tab_id:" . self::PAGE_TABS_BLOCK_ID . "JsTabs.activeTab.id});
                editForm.submit(url);
            }
        ";
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back' => 'edit',
            'tab' => '{{tab_id}}',
            'active_tab' => null
        ));
    }

    /**
     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_productslider')
            && Mage::registry('current_productslider')->getId()
        ) {
            return Mage::helper('productslider')->__("Edit Item '%s'",
                $this->htmlEscape(Mage::registry('current_productslider')->getName())
            );
        }
        return Mage::helper('productslider')->__('Add Slider');
    }
}