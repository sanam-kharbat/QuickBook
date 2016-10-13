<?php

class Mageplaza_ProductSlider_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'productslider/general/is_enabled';
    const XML_PATH_GENERAL_CONFIG = 'productslider/general/';


    const XML_PATH_ENABLED_NEW = 'productslider/label/is_enabled_new';
    const XML_PATH_NEW_PRODUCT_LABEL = 'productslider/label/new_product_label';
    const XML_PATH_NEW_BACKGROUND_COLOR = 'productslider/label/new_background_color';
    const XML_PATH_NEW_TEXT_PRODUCT_COLOR = 'productslider/label/new_text_product_color';

    const XML_PATH_ENABLED_SALE = 'productslider/label/is_enabled_sale';
    const XML_PATH_SALE_LABEL = 'productslider/label/sale_label';
    const XML_PATH_SALE_BACKGROUND = 'productslider/label/sale_background';
    const XML_PATH_SALE_TEXT_COLOR = 'productslider/label/sale_text_color';


//	public function getPosition($storeId=null){
//		if(!$storeId){
//			$storeId= Mage::app()->getStore()->getId();
//		}
//		return Mage::getStoreConfig(self::XML_PATH_NEW_FEATURE_POSITION,$storeId);
//	}


    public function isEnabled($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_ENABLED, $storeId);
    }

    public function isEnabledNew($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_ENABLED_NEW, $storeId);
    }


    public function getGeneralConfig($name, $storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_GENERAL_CONFIG . $name, $storeId);

    }

    public function getNewProductLabel($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_NEW_PRODUCT_LABEL, $storeId);
    }


    public function getNewBackGroundColor($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_NEW_BACKGROUND_COLOR, $storeId);
    }

    public function getNewTextColor($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_NEW_TEXT_PRODUCT_COLOR, $storeId);
    }


//	public function getNewProductPosition($storeId=null){
//		if(!$storeId){
//			$storeId= Mage::app()->getStore()->getId();
//		}
//		return Mage::getStoreConfig(self::XML_PATH_NEW_FEATURE_POSITION,$storeId);
//	}

    public function isEnabledSale($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_ENABLED_SALE, $storeId);
    }

    public function getSaleLabel($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_SALE_LABEL, $storeId);
    }

    public function getSaleBackGround($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_SALE_BACKGROUND, $storeId);
    }

    public function getSaleTextColor($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        return Mage::getStoreConfig(self::XML_PATH_SALE_TEXT_COLOR, $storeId);
    }

}