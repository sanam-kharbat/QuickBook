<?php

class Mageplaza_productslider_Model_Position extends Varien_Object
{

    /**
     * get model option as array
     *
     * @return array
     */

    public function toOptionArray()
    {
        return array(
            array(
                'label' => Mage::helper('productslider')->__('------- Please choose position -------'),
                'value' => ''),
            array(
                'label' => Mage::helper('productslider')->__('General (will be display on all pages)'),
                'value' => array(
                    array('value' => 'top_left', 'label' => Mage::helper('productslider')->__('Top Left')),
                    array('value' => 'top_right', 'label' => Mage::helper('productslider')->__('Top Right')),
                    array('value' => 'top_center', 'label' => Mage::helper('productslider')->__('Top Center')),

                    array('value' => 'center_left', 'label' => Mage::helper('productslider')->__('Center Left')),
                    array('value' => 'center_right', 'label' => Mage::helper('productslider')->__('Center Right')),
                    array('value' => 'center_center', 'label' => Mage::helper('productslider')->__('Center Center')),

                    array('value' => 'bottom_left', 'label' => Mage::helper('productslider')->__('Bottom Left')),
                    array('value' => 'bottom_right', 'label' => Mage::helper('productslider')->__('Bottom Right')),
                    array('value' => 'bottom_center', 'label' => Mage::helper('productslider')->__('Bottom Center')),


                )),
        );
    }

    public static function getPositionOptions()
    {
        return array(
            'cms_page_sliderTop' => Mage::helper('productslider')->__('Homepage-Content-Top'),
            'right_sliderTop' => Mage::helper('productslider')->__('Sidebar Right Top'),
            'right_sliderBottom' => Mage::helper('productslider')->__('Sidebar Right Bottom'),
            'left_first_sliderTop' => Mage::helper('productslider')->__('Sidebar Top Left'),
            'left_sliderBottom' => Mage::helper('productslider')->__('Sidebar Bottom Left'),
            'content_sliderTop' => Mage::helper('productslider')->__('Content Top'),
            'topMenu_sliderTop' => Mage::helper('productslider')->__('Menu Top'),
            'topMenu_sliderBottom' => Mage::helper('productslider')->__('Menu Bottom'),
            'before_body_end_sliderTop' => Mage::helper('productslider')->__('Page Bottom'),
        );
    }

    public static function getBlockPosition()
    {
        return array(
            array(
                'label' => Mage::helper('productslider')->__('------- Please choose position -------'),
                'value' => ''),
            array(
                'label' => Mage::helper('productslider')->__('Popular positions'),
                'value' => array(
                    array('value' => 'cms_page_sliderTop', 'label' => Mage::helper('productslider')->__('Homepage-Content-Top')),
                )),
            array(
                'label' => Mage::helper('productslider')->__('General (will be display on all pages)'),
                'value' => array(
                    array('value' => 'right_sliderTop', 'label' => Mage::helper('productslider')->__('Sidebar Right Top')),
                    array('value' => 'right_sliderBottom', 'label' => Mage::helper('productslider')->__('Sidebar Right Bottom')),
                    array('value' => 'left_first_sliderTop', 'label' => Mage::helper('productslider')->__('Sidebar Top Left')),
                    array('value' => 'left_sliderBottom', 'label' => Mage::helper('productslider')->__('Sidebar Bottom Left')),
                    array('value' => 'content_sliderTop', 'label' => Mage::helper('productslider')->__('Content Top')),
                    array('value' => 'topMenu_sliderTop', 'label' => Mage::helper('productslider')->__('Menu Top')),
                    array('value' => 'topMenu_sliderBottom', 'label' => Mage::helper('productslider')->__('Menu Bottom')),
                    array('value' => 'before_body_end_sliderTop', 'label' => Mage::helper('productslider')->__('Page Bottom')),
                )),
        );
    }

    public function getDefaultPositionBlock()
    {
        return array('cms_page', 'right', 'left', 'left_first', 'content', 'topMenu', 'before_body_end');
    }

}