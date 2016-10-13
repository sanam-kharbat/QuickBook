<?php

$installer = $this;

$installer->startSetup();

$installer->run("

");

if (version_compare(Mage::getVersion(), '1.9.2.1', '>')) {
    $blocks = array(
        'productslider/productslider',
    );
    foreach ($blocks as $_block) {
        $this->_saveBlock($_block);
    }
}

$installer->endSetup();
