<?php

class Mageplaza_ProductSlider_Model_Resource_Setup extends Mage_Catalog_Model_Resource_Setup
{


    public function insertDefaultBlocks()
    {
        if (version_compare(Mage::getVersion(), '1.9.2.1', '>')) {
            $blocks = array(
                'mageplaza_betterblog/post_recent',
                'mageplaza_betterblog/post_cat',
                'mageplaza_betterblog/post_list',
                'mageplaza_betterblog/post_view',
                'mageplaza_betterblog/category_list',
                'mageplaza_betterblog/tag_list',
            );
            foreach ($blocks as $_block) {
                $this->_saveBlock($_block);
            }
        }
    }

    protected function _saveBlock($name = '')
    {
        try {

            if (empty($name)) return;
            $data = array(
                'block_name' => $name,
                'is_allowed' => 1
            );
            $model = Mage::getModel('admin/block')->load($name);
            if ($model->getId()) {
                return;
            }
            $model->setData($data);
            $model->save();
        } catch (Exception $e) {
        }
    }
}