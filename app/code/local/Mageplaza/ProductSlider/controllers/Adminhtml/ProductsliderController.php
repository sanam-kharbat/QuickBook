<?php

class Mageplaza_ProductSlider_Adminhtml_ProductsliderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * init layout and set active for current menu
     *
     * @return Mageplaza_ProductSlider_Adminhtml_ProductsliderController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('productslider/productslider')
            ->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Items Manager'),
                Mage::helper('adminhtml')->__('Item Manager')
            );

        return $this;
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout()
            ->renderLayout();
    }

    public function _initSlider()
    {
        $sliderId = $this->getRequest()->getParam('id');

        $slider = Mage::getModel('productslider/productslider');

        if ($sliderId) {
            $slider->load($sliderId);
            if (!$slider->getId()) {
                $this->_getSession()->addError($this->__('This slider no longer exists.'));
                $this->_redirect('*/*/');
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);

                return false;
            } else {
                $sliderConfig = Mage::helper('core')->jsonDecode($slider->getSliderConfig());
                $slider->addData($sliderConfig);
            }
        } else {
            //new slider. Set default value
            $configSlider = array(
                'show_addtocart',
                'show_price',
                'show_rating',
                'show_review',
                'show_description',
                'show_name',
                'auto_play',
                'navigation',
                'pagination',
                'stop_on_hover',
                'lazy_loading',
                'auto_height',
                'mouse_drag',
                'touch_drag',
                'add_class_active',
                'include_jquery',
            );
            foreach ($configSlider as $key) {
                $slider->setData($key, 1);
            }
            $slider->setItems(6);
            $slider->setSlideSpeed(600);
            $slider->setLimit(10);
        }

        return $slider;
    }

    /**
     * view and edit item action
     */
    public function editAction()
    {
        if ($slider = $this->_initSlider()) {

            $data = $this->_getSession()->getFormData();
            if (!empty($data)) {
                $slider->setData($data);
            }
            Mage::register('current_productslider', $slider);
            $this->_initAction()
                ->_title($slider->getId() ? $slider->getProductId() : $this->__('New Slider'))
                ->_addBreadcrumb(
                    $slider->getProductId() ? $this->__('Edit Slider') : $this->__('New Slider'),
                    $slider->getProductId() ? $this->__('Edit Slider') : $this->__('New Slider')
                );
            $this->_title($this->__('Product Slider'))->_title($this->__('%s Slider', ucfirst($this->getRequest()->getParam('type'))));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true)
                ->setCanLoadRulesJs(true);
            $this->_addContent($this->getLayout()->createBlock('productslider/adminhtml_productslider_edit'))
                ->_addLeft($this->getLayout()->createBlock('productslider/adminhtml_productslider_edit_tabs'));

            $this->renderLayout();
        } else {
            $this->_redirect('*/*/');
        }

        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save item action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('productslider/productslider');

            try {
                /**
                 * Save config slider
                 */
                $sliderOptions = array();
                $configSlider = array(
                    'items',
                    'auto_play',
                    'slide_speed',
                    'navigation',
                    'pagination',
                    'stop_on_hover',
                    'lazy_loading',
                    'auto_height',
                    'mouse_drag',
                    'touch_drag',
                    'effect',
                    'add_class_active',
                    'limit',
                    'category_id',
                    'include_jquery',
                    'product_ids'
                );
                foreach ($configSlider as $config) {
                    if (isset($data[$config])) {
                        $sliderOptions[$config] = $data[$config];
                        unset($data[$config]);
                    }
                }


                $data['slider_config'] = Mage::helper('core')->jsonEncode($sliderOptions);

                $model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('productslider')->__('Item was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back', false)) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));

                    return;
                }
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('productslider')->__('Unable to find item to save')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete item action
     */
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('productslider/productslider');
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Item was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * mass delete item(s) action
     */
    public function massDeleteAction()
    {
        $productsliderIds = $this->getRequest()->getParam('productslider');
        if (!is_array($productsliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($productsliderIds as $productsliderId) {
                    $productslider = Mage::getModel('productslider/productslider')->load($productsliderId);
                    $productslider->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted',
                        count($productsliderIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass change status for item(s) action
     */
    public function massStatusAction()
    {
        $productsliderIds = $this->getRequest()->getParam('productslider');
        if (!is_array($productsliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($productsliderIds as $productsliderId) {
                    Mage::getSingleton('productslider/productslider')
                        ->load($productsliderId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($productsliderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('productslider');
    }
}