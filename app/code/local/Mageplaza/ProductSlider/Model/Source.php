<?php

class Mageplaza_ProductSlider_Model_Source extends Varien_Object
{

    /**
     * get model option as array
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            'new_products' => Mage::helper('productslider')->__('New Products'),
            'feature_products' => Mage::helper('productslider')->__('Featured Products'),
            'most_view' => Mage::helper('productslider')->__('Most Views'),
            'bestseller' => Mage::helper('productslider')->__('Bestseller'),
            'on_sale' => Mage::helper('productslider')->__('On Sale'),
            'created_at' => Mage::helper('productslider')->__('Recent added'),
            'random' => Mage::helper('productslider')->__('Random Products'),
            'category_id' => Mage::helper('productslider')->__('Category ID'),
//            'product_ids' => Mage::helper('productslider')->__('Product IDs'),
        );
    }

    /**
     * get model option hash as array
     *
     * @return array
     */
    static public function getOptionHash()
    {
        $options = array();
        foreach (self::getOptionArray() as $value => $label) {
            $options[] = array(
                'value' => $value,
                'label' => $label
            );
        }

        return $options;
    }
}