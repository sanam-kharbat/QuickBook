<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * create productslider table
 */

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('productslider/productslider')};

CREATE TABLE {$this->getTable('productslider/productslider')} (
  `productslider_id` int(11) NOT NULL AUTO_INCREMENT,
  `source_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_ids` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_name` tinyint(4) DEFAULT NULL,
  `show_description` tinyint(4) DEFAULT NULL,
  `show_review` tinyint(4) DEFAULT NULL,
  `show_rating` tinyint(4) DEFAULT NULL,
  `show_price` tinyint(4) DEFAULT NULL,
  `show_addtocart` tinyint(4) DEFAULT NULL,
  `active_form` datetime DEFAULT NULL,
  `active_to` datetime DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) DEFAULT NULL,
  `slider_config` text,
  PRIMARY KEY (`productslider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
");

try {

  $setup = Mage::getResourceModel('catalog/setup', 'mageplaza_productslider_setup');
  $setup->removeAttribute('catalog_product', 'is_feature');
  $setup->addAttribute('catalog_product', 'is_feature', array(
      'group' => 'General',
      'type' => 'int',
      'backend' => '',
      'frontend' => '',
      'label' => 'Feature Product',
      'input' => 'select',
      'source' => 'productslider/source_feature',
      'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
      'visible' => true,
      'required' => false,
      'user_defined' => true,
      'default' => '0',
      'searchable' => false,
      'filterable' => false,
      'comparable' => false,
      'visible_on_front' => false,
      'unique' => false,
      'apply_to' => '',
      'is_configurable' => false,
      'used_in_product_listing' => true,
      'sort_order' => 1000,
  ));

} catch (Exception $e) {
    Mage::log($e->getMessage());
}

try {
    $this->insertDefaultBlocks();
} catch (Exception $e) {
    Mage::log($e->getMessage());
}


$installer->endSetup();

