<?php

class Mageplaza_ProductSlider_Model_Mysql4_Productslider_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productslider/productslider');
    }

    public function getAvailableSlider($storeId = null)
    {
        $this->addFieldToFilter('status', Mageplaza_ProductSlider_Model_Status::STATUS_ENABLED);
        if (!is_null($storeId)) {
            $this->addFieldToFilter('store_ids', array('finset' => (int)$storeId));
        }
        $filterDate = Mage::getModel('core/date')->date();
        $this->getSelect()->where('(active_form IS NULL) OR (date(active_form) <= date(?))', $filterDate);
        $this->getSelect()->where('(active_to IS NULL) OR (date(active_to) >= date(?))', $filterDate);

        return $this;
    }
}