<?php


class Mageplaza_ProductSlider_Model_Source_Feature extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const TYPE_NO = 0;
    const TYPE_YES = 1;

    public function getAllOptions()
    {
        $result = array();
        foreach ($this->toOptionArray() as $k => $v) {
            $result[] = array(
                'value' => $k,
                'label' => $v,
            );
        }

        return $result;
    }

    public function toOptionArray()
    {
        return array(
            self::TYPE_YES => Mage::helper('productslider')->__('Yes'),
            self::TYPE_NO => Mage::helper('productslider')->__('No'),
        );
    }
}
