<?php

class Mageplaza_ProductSlider_Block_Productslider extends Mage_Catalog_Block_Product_Abstract
{
    protected $_sliderId;

    /**
     * prepare block's layout
     *
     * @return Mageplaza_ProductSlider_Block_Productslider
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }


    /**
     * get product collection
     * @param $slider
     * @return Mage_Catalog_Model_Resource_Product_Collection|Mage_Reports_Model_Resource_Product_Collection|Varien_Data_Collection
     */
    public function getProducts($slider)
    {
        if ($this->hasData('product_collection')) {
            return $this->getProductCollection();
        } else {
            $dir = $slider->getOrderingDirection();
            $orderBy = $slider->getOrderBy();
            $storeId = (int)Mage::app()->getStore()->getId();

            $collection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addUrlRewrite()
                ->addTaxPercents()
                ->addStoreFilter();

            switch ($slider->getSourceType()) {

                /**
                 * NEW PRODUCTS
                 */
                case 'new_products':
                    $todayDate = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
                    $collection
                        ->addAttributeToFilter(
                            'news_from_date',
                            array(
                                'date' => true,
                                'to' => $todayDate
                            )
                        )
                        ->addAttributeToFilter(array(
                            array(
                                'attribute' => 'news_to_date',
                                'date' => true,
                                'from' => $todayDate
                            ),
                            array(
                                'attribute' => 'news_to_date',
                                'is' => new Zend_Db_Expr('null')
                            )
                        ),
                            '',
                            'left'
                        );

                    break;

                /**
                 * FEATURED PRODUCTS
                 */
                case 'feature_products':
                    $collection->addAttributeToFilter('is_feature', 1);

                    break;

                /**
                 * RECENT ADDED PRODUCTS
                 */
                case 'created_at':
                case 'updated_at':
                    $fieldorder = $slider->getProductSource();
                    $collection = Mage::getResourceModel('catalog/product_collection')
                        ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                        ->addMinimalPrice()
                        ->addUrlRewrite()
                        ->addTaxPercents()
                        ->addStoreFilter()
                        ->setOrder($fieldorder, $dir);

                    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                    Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
                    $collection->setPageSize($slider->getLimit())->setCurPage(1);
                    $this->setProductCollection($collection);
                    return $collection;

                    break;


                /**
                 * MOST VIEWS PRODUCTS
                 */
                case 'most_view':
                    $storeId = Mage::app()->getStore()->getId();
                    $collection = Mage::getResourceModel('reports/product_collection')
                        ->addAttributeToSelect('*')
                        ->addMinimalPrice()
                        ->addUrlRewrite()
                        ->addTaxPercents()
                        ->addAttributeToSelect(array('name', 'price', 'small_image'))//edit to suit tastes
                        ->setStoreId($storeId)
                        ->addStoreFilter($storeId)
                        ->addViewsCount();
                    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                    Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
                    $collection->setPageSize($slider->getLimit())->setCurPage(1);

                    $this->setProductCollection($collection);

                    return $collection;

                    break;

                /**
                 * BESTSELLER PRODUCTS
                 */
                case 'bestseller':
                    //Ref: http://inchoo.net/magento/bestseller-products-in-magento/
                    $storeId = (int)Mage::app()->getStore()->getId();

                    // Date
                    $date = new Zend_Date();
                    $toDate = $date->setDay(1)->getDate()->get('Y-MM-dd');
                    $fromDate = $date->subMonth(1)->getDate()->get('Y-MM-dd');

                    $collection = Mage::getResourceModel('catalog/product_collection')
                        ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                        ->addStoreFilter()
                        ->addPriceData()
                        ->addTaxPercents()
                        ->addUrlRewrite()
                        ->setPageSize(6);

                    $collection->getSelect()
                        ->joinLeft(
                            array('aggregation' => $collection->getResource()->getTable('sales/bestsellers_aggregated_monthly')),
                            "e.entity_id = aggregation.product_id AND aggregation.store_id={$storeId} AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'",
                            array('SUM(aggregation.qty_ordered) AS sold_quantity')
                        )
                        ->group('e.entity_id')
                        ->order(array('sold_quantity DESC', 'e.created_at'));

                    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                    Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

                    return $collection;

                    break;

                /**
                 * ON SALE products
                 */
                case 'on_sale':

                    $todayDate = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
                    $collection = Mage::getResourceModel('reports/product_collection')
                        ->addAttributeToSelect('*')
                        ->addAttributeToFilter('visibility', array('neq' => 1))
                        ->addAttributeToFilter('special_price', array('neq' => ''))
                        ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
                        ->addAttributeToFilter('special_to_date', array('or' => array(
                            0 => array('date' => true, 'from' => $todayDate),
                            1 => array('is' => new Zend_Db_Expr('null')))
                        ), 'left')
                        ->addAttributeToSort('special_from_date', 'desc');
                    $collection->load();

                    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                    Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
                    $collection->setPageSize($slider->getLimit())->setCurPage(1);
                    $this->setProductCollection($collection);
                    return $collection;

                    break;

                /**
                 * PRODUCTS BY CATEGORY ID
                 */
                case 'category_id':


                    $collection = Mage::getResourceModel('catalog/product_collection')
                        ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                        ->addMinimalPrice()
                        ->addUrlRewrite()
                        ->addTaxPercents()
                        ->addStoreFilter();

                    if ($ids = $slider->getCategoryId()) {
                        $category = Mage::getModel('catalog/category')->load($ids);
                        if (!is_null($category)) {
                            $collection->addCategoryFilter($category);
                        }
                    } else {
                        /**
                         * there is no product
                         */
                        $this->setProductCollection(null);
                        return null;
                    }

                    $collection
                        ->setPageSize($slider->getLimit())
                        ->setCurPage(1);
                    $this->setProductCollection($collection);

                    return $collection;
                    break;

                case 'product_ids':

                    $collection = Mage::getResourceModel('catalog/product_collection')
                        ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                        ->addMinimalPrice()
                        ->addUrlRewrite()
                        ->addTaxPercents()
                        ->addStoreFilter()//                        ->setOrder($orderBy, $dir)
                    ;

                    if ($ids = $slider->getProductIds()) {
                        $collection->addIdFilter($ids);
                    } else {
                        /**
                         * there is no IDS, return empty collection
                         */
                        return null;
                    }


                    $collection
                        ->setPageSize($slider->getLimit())
                        ->setCurPage(1);

                    $this->setProductCollection($collection);
                    return $collection;

                    break;

                case 'random':

                    /* @var $products Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
                    $collection = Mage::getModel('catalog/product')
                        ->getCollection()
                        ->addAttributeToSort('id')
                        ->addAttributeToSelect('*');
                    $collection->getSelect()->order(new Zend_Db_Expr('RAND()'));

                    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                    Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);


                    return $collection;


                    break;


                default:
                    break;
            }

            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
            $collection->setPageSize($slider->getLimit())->setCurPage(1);
            $this->setProductCollection($collection);

            return $collection;
        }
    }

    /**
     * get slider html ID attribute
     * @param $slider
     * @return string
     */
    public function getSliderIdHtml($slider)
    {
        if ($this->getData('slider_id_html')) {
            $sliderIdHtml = $this->getData('slider_id_html');
        } else {
            $sliderIdHtml = Mage::registry('number_of_slider') ? Mage::registry('number_of_slider') : 0;

            Mage::unregister('number_of_slider');
            Mage::register('number_of_slider', ++$sliderIdHtml);

            $this->setData('slider_id_html', $sliderIdHtml);
        }

        return $slider->getId() . '-' . $sliderIdHtml;
    }

    /**
     * get slider ID
     * @param $sliderId
     * @return $this
     */
    public function setProductsliderId($sliderId)
    {
        $this->_sliderId = $sliderId;

        return $this;
    }

    /**
     * get slider data
     * @return Mageplaza_ProductSlider_Model_Productslider
     */
    public function getSliderData()
    {
        $slider = $this->getSlider();
        if (!$slider) {
            if (!($sliderId = $this->getProductsliderId())) {
                $sliderId = $this->_sliderId;
            }
            $slider = Mage::getModel('productslider/productslider')->load($sliderId);
        }

        return $slider;
    }


    /**
     * get slider config in json format
     * @return string
     */
    public function getJsonConfig()
    {
        $sliderConfig = $this->getSliderConfig();
        foreach ($sliderConfig as $key => $value) {
            $config[$this->getJsKeyName($key)] = $this->getJsKeyValue($value);
        }

        return Mage::helper('core')->jsonEncode($config);
    }

    /**
     * get Slider config in array
     * @return mixed
     */
    public function getSliderConfig()
    {
        $slider = $this->getSliderData();
        $sliderConfig = Mage::helper('core')->jsonDecode($slider->getSliderConfig());
        return $sliderConfig;
    }


    /**
     * get value by key
     * @param $key
     * @return string
     */
    public function getJsKeyName($key)
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

        return $name;
    }

    /**
     * @param $value
     * @return bool
     */
    public function getJsKeyValue($value)
    {
        if (in_array((int)$value, array(0, 1))) {
            return (bool)$value;
        }

        return $value;
    }


}