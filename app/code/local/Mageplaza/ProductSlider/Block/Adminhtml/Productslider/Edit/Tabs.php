<?php

class Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productslider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('productslider')->__('Slider Information'));
    }

    /**
     * prepare before render block to html
     *
     * @return Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Edit_Tabs
     */
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('productslider')->__('Slider Information'),
            'title' => Mage::helper('productslider')->__('Slider Information'),
            'content' => $this->getLayout()
                ->createBlock('productslider/adminhtml_productslider_edit_tab_form')
                ->toHtml(),
        ));

        $slider = Mage::registry('current_productslider');
        if ($slider && $slider->getId()) {
            $this->addTab('implement_section', array(
                'label' => Mage::helper('productslider')->__('Implement Code'),
                'title' => Mage::helper('productslider')->__('Implement Code'),
                'content' => $this->getLayout()->createBlock('productslider/adminhtml_productslider_edit_tab_implement')->toHtml(),
            ));
        }

        $this->_updateActiveTab();
        return parent::_beforeToHtml();
    }

    protected function _updateActiveTab()
    {
        $tabId = $this->getRequest()->getParam('tab');
        if ($tabId) {
            $tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
            if ($tabId) {
                $this->setActiveTab($tabId);
            }
        }
    }
}