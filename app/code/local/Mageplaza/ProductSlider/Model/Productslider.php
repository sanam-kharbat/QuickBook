<?php

class Mageplaza_ProductSlider_Model_Productslider extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productslider/productslider');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();

        if ($this->hasPosition()) {
            $position = $this->getPosition();
            if (is_array($position) && !empty($position)) {
                $this->setPosition(implode(',', $position));
            }
        }

        if ($this->hasStores()) {
            $groupIds = $this->getStores();
            if (is_array($groupIds) && !empty($groupIds)) {
                $this->setStoreIds(implode(',', $groupIds));
            }
        }

        return $this;
    }

    /**
     * prevent fill multiple category IDs
     * @return null
     */
    public function getCatId()
    {
        $ids = $this->getCategoryId();
        if ($ids) {
            $pies = explode(',', $ids);
            if (isset($pies[0])) return $pies[0];
        }
        return null;
    }

    /**
     * get slider config
     * @return mixed
     */
    public function getSliderConfigData()
    {
        $sliderConfig = Mage::helper('core')->jsonDecode($this->getSliderConfig());
        return $sliderConfig;

    }

    /**
     * get slider config by key
     * @param $key
     * @return null
     */
    public function getConfigByKey($key)
    {
        if (!$key) return null;
        $config = $this->getSliderConfigData();

        if (isset($config[$key])) return $config[$key];

        return null;
    }

    /**
     * alias of getConfigByKey function
     * @param $key
     * @return null
     */
    public function getConfig($key)
    {
        return $this->getConfigByKey($key);
    }

    public function getLimit()
    {
        return $this->getConfig('limit');
    }

    public function getCategoryId()
    {
        return $this->getConfig('category_id');
    }

    public function getProductIds()
    {
        $ids = $this->getConfig('product_ids');
        if (!$ids) return array();
        $ids = trim($ids);
        $ids = explode(',', $ids);
        return $ids;

    }
}