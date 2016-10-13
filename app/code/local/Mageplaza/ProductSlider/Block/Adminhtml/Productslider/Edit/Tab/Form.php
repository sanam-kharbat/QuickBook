<?php

class Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare tab form's information
     *
     * @return Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Edit_Tab_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $slider = Mage::registry('current_productslider');

        $fieldset = $form->addFieldset('productslider_form', array(
            'legend' => Mage::helper('productslider')->__('General')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('productslider')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));


        $fieldset->addField('source_type', 'select', array(
            'label' => Mage::helper('productslider')->__('Source'),
            'name' => 'source_type',
            'values' => Mage::getSingleton('productslider/source')->getOptionHash(),
        ));

        $fieldset->addField('category_id', 'text', array(
            'label' => Mage::helper('productslider')->__('Category ID'),
            'required' => false,
            'name' => 'category_id',
            'note' => 'Enter ONLY ONE category ID if you selected <strong>Source is Category ID</strong>. E.g: 3.',
        ));

//        $fieldset->addField('product_ids', 'text', array(
//            'label' => Mage::helper('productslider')->__('Product IDs'),
//            'required' => false,
//            'name' => 'product_ids',
//            'note' => 'Enter product IDs if you selected <strong>Source is Product IDs</strong>. E.g: 3,4,5,10. <strong>Separate by comma</strong>',
//        ));


        $fieldset->addField('limit', 'text', array(
            'label' => Mage::helper('productslider')->__('Limit products'),
            'required' => false,
            'name' => 'limit',
            'note' => 'Max number of products on this sliders. E.g: 10',
        ));

        $fieldset->addField('include_jquery', 'select', array(
            'label' => Mage::helper('productslider')->__('Include jQuery'),
            'name' => 'include_jquery',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            'note' => 'If your site has included jQuery, you can disable this by selecting No.'
        ));


        $store = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false);
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_ids', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('productslider')->__('Store View'),
                'title' => Mage::helper('productslider')->__('Store View'),
                'required' => true,
                'values' => $store,
            ));
        } else {
            $fieldset->addField('store_ids', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));

            $slider->setData('store_ids', Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('position', 'multiselect', array(
            'label' => Mage::helper('productslider')->__('Display on'),
            'name' => 'position',
            'values' => Mage::getSingleton('productslider/position')->getBlockPosition(),
            'note' => 'Due to custom design reason. This function may not work, you can use snippet in <strong>Implement Code</strong> tab and copy to CMS Page/Static block, .phtml or layout.<br>
                    <a href="https://mageplaza.freshdesk.com/support/solutions/articles/6000117338-display-product-slider-in-checkout-page" target="_blank">Insert Product slider to checkout page</a>
                    '
        ));


        $fieldset->addField('active_form', 'date', array(
            'name' => 'active_form',
            'label' => Mage::helper('productslider')->__('Active Form'),
            'title' => Mage::helper('productslider')->__('Active Form'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField('active_to', 'date', array(
            'name' => 'active_to',
            'label' => Mage::helper('productslider')->__('Active To'),
            'title' => Mage::helper('productslider')->__('Active To'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('productslider')->__('Status'),
            'name' => 'status',
            'values' => Mage::getSingleton('productslider/status')->getOptionHash(),
        ));


        //------------------------------- Display ----------------------------------------------//
        $fieldset = $form->addFieldset('productslider_display', array(
            'legend' => Mage::helper('productslider')->__('Display')
        ));

        $fieldset->addField('show_name', 'select', array(
            'label' => Mage::helper('productslider')->__('Show Name'),
            'name' => 'show_name',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('show_description', 'select', array(
            'label' => Mage::helper('productslider')->__('Show Description'),
            'name' => 'show_description',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('show_review', 'select', array(
            'label' => Mage::helper('productslider')->__('Show Review'),
            'name' => 'show_review',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('show_rating', 'select', array(
            'label' => Mage::helper('productslider')->__('Show Rating'),
            'name' => 'show_rating',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('show_price', 'select', array(
            'label' => Mage::helper('productslider')->__('Show Price'),
            'name' => 'show_price',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('show_addtocart', 'select', array(
            'label' => Mage::helper('productslider')->__('Show Add to cart button'),
            'name' => 'show_addtocart',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        //------------------------------- Product Labels ----------------------------------------------//
//		$fieldset = $form->addFieldset('productslider_labels', array(
//			'legend' => Mage::helper('productslider')->__('Product Labels'),
//		));
//
//		$fieldset->addField('product_enable', 'select', array(
//			'label'  => Mage::helper('productslider')->__('Enable Label'),
//			'name'   => 'product_enable',
//			'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
//		));
//
//		$fieldset->addField('custom', 'select', array(
//			'label'  => Mage::helper('productslider')->__('Custom'),
//			'name'   => 'custom',
//			'values' => Mage::getSingleton('productslider/custom')->toOptionArray()
//		));
//
//			$fieldset->addField('background_color', 'text', array(
//				'label'  => Mage::helper('productslider')->__('Background Color'),
//				'name'   => 'background_color',
//			));
//
//			$fieldset->addField('text_color', 'text', array(
//				'label'  => Mage::helper('productslider')->__('Color'),
//				'name'   => 'text_color',
//			));
//
//
//		$this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
//				->addFieldMap("product_enable", 'product_enable')
//				->addFieldMap("custom", 'custom')
//				->addFieldMap("background_color", 'background_color')
//				->addFieldMap("text_color", 'text_color')
//				->addFieldMap("show_sale_label", 'show_sale_label')
//				->addFieldDependence('custom', 'product_enable', '1')
//				->addFieldDependence('background_color', 'custom', '1')
//				->addFieldDependence('text_color', 'custom', '1')
//				->addFieldDependence('background_color', 'product_enable', '1')
//				->addFieldDependence('text_color', 'product_enable', '1')
//		);


        //-------------------------------Slider option ----------------------------------------------//

        $fieldset = $form->addFieldset('productslider_slider_option', array(
            'legend' => Mage::helper('productslider')->__('Slider Option')
        ));

        $fieldset->addField('items', 'text', array(
            'label' => Mage::helper('productslider')->__('Number of products per row'),
            'required' => true,
            'name' => 'items',
            'note' => 'Number of product in one row. E.g: 4,6',
        ));

        $fieldset->addField('auto_play', 'select', array(
            'label' => Mage::helper('productslider')->__('Auto Play'),
            'name' => 'auto_play',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('slide_speed', 'text', array(
            'label' => Mage::helper('productslider')->__('Slide Speed'),
            'required' => true,
            'name' => 'slide_speed',
            'note' => 'E.g: 300, 500. (Milliseconds)',
        ));


        $fieldset->addField('navigation', 'select', array(
            'label' => Mage::helper('productslider')->__('Navigation'),
            'name' => 'navigation',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('pagination', 'select', array(
            'label' => Mage::helper('productslider')->__('Pagination'),
            'name' => 'pagination',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('stop_on_hover', 'select', array(
            'label' => Mage::helper('productslider')->__('Stop on hover'),
            'name' => 'stop_on_hover',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('lazy_loading', 'select', array(
            'label' => Mage::helper('productslider')->__('Lazy Loading'),
            'name' => 'lazy_loading',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('auto_height', 'select', array(
            'label' => Mage::helper('productslider')->__('Auto Height'),
            'name' => 'auto_height',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));


        $fieldset->addField('mouse_drag', 'select', array(
            'label' => Mage::helper('productslider')->__('Mouse Drag'),
            'name' => 'mouse_drag',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));


        $fieldset->addField('touch_drag', 'select', array(
            'label' => Mage::helper('productslider')->__('Touch Drag'),
            'name' => 'touch_drag',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ));


        $fieldset->addField('effect', 'select', array(
            'label' => Mage::helper('productslider')->__('Slide Effect'),
            'name' => 'effect',
            'values' => Mage::getSingleton('productslider/effect')->getOptionHash(),
        ));

        $fieldset->addField('add_class_active', 'select', array(
            'label' => Mage::helper('productslider')->__('Add Active Class'),
            'name' => 'add_class_active',
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()

        ));


        $form->setValues($slider);

        return parent::_prepareForm();
    }
}