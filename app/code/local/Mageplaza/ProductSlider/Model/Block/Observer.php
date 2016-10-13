<?php

class Mageplaza_ProductSlider_Model_Block_Observer
{
    protected static $flagPopup = true;
    protected $_storeId = null;
    protected $_defaultPosition = array();
    protected $_collection = array();

    public function afterOutputHtml($observer)
    {
        if (!Mage::helper('productslider')->isEnabled()) {
            return $this;
        }
        $block = $observer->getEvent()->getBlock();
        $transport = $observer->getEvent()->getTransport();
        $blockAlias = $block->getBlockAlias();

        if (!$this->_storeId) {
            $this->_storeId = Mage::app()->getStore()->getId();
            $this->_defaultPosition = Mage::getModel('productslider/position')->getDefaultPositionBlock();
            $this->_collection = Mage::getModel('productslider/productslider')->getCollection()
                ->getAvailableSlider($this->_storeId);
        }

        if (!in_array($blockAlias, $this->_defaultPosition)) {
            return $this;
        }

        $html = $transport->getHtml();
        foreach ($this->_collection as $slider) {
            $sliderPosition = explode(',', $slider->getPosition());
            if (in_array($blockAlias . '_sliderTop', $sliderPosition)) {
                $this->_showSlider($block, $html, $slider, true);
            } elseif (in_array($blockAlias . '_sliderBottom', $sliderPosition)) {
                $this->_showSlider($block, $html, $slider, false);
            }
        }
        $transport->setHtml($html);

        return $this;
    }

    protected function _showSlider($block, &$html, $slider, $position)
    {
        $append_html = $block->getLayout()->createBlock('productslider/productslider')
            ->setSlider($slider)
            ->setTemplate('mageplaza/productslider/productslider.phtml')
            ->renderView();

        $html = $position ? $append_html . $html : $html . $append_html;

        return $this;
    }
}
