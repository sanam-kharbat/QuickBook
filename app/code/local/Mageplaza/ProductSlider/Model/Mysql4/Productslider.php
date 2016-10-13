<?php

class Mageplaza_ProductSlider_Model_Mysql4_Productslider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('productslider/productslider', 'productslider_id');
    }
}