<?php

class Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productsliderGrid');
        $this->setDefaultSort('productslider_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection for block to display
     *
     * @return Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('productslider/productslider')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        foreach ($collection as $item) {
            if ($storeIds = $item->getStoreIds()) {
                $item->setStoreIds(explode(',', $storeIds));
            }
        }

        return $this;
    }

    /**
     * prepare columns for this grid
     *
     * @return Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Grid
     */
    protected function _prepareColumns()
    {

        $this->addColumn('productslider_id', array(
            'header' => Mage::helper('productslider')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'productslider_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('productslider')->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_ids', array(
                'header' => Mage::helper('productslider')->__('Store View'),
                'index' => 'store_ids',
                'type' => 'store',
                'align' => 'center',
                'store_all' => true,
                'store_view' => true,
                'sortable' => true,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
                'width' => '150px',
            ));
        }


//		$this->addColumn('active_form', array(
//			'header'    => Mage::helper('productslider')->__('Customer Since'),
//			'type'      => 'datetime',
//			'align'     => 'center',
//			'index'     => 'created_at',
//			'gmtoffset' => true
//		));

        $this->addColumn('active_form', array(
            'header' => Mage::helper('productslider')->__('Active From'),
            'type' => 'datetime',
            'width' => '150px',
            'index' => 'active_form',
        ));

        $this->addColumn('active_to', array(
            'header' => Mage::helper('productslider')->__('Active To'),
            'type' => 'datetime',
            'width' => '150px',
            'index' => 'active_to',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('productslider')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('productslider')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('productslider')->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id'
                    )),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ));

//        $this->addExportType('*/*/exportCsv', Mage::helper('productslider')->__('CSV'));
//        $this->addExportType('*/*/exportXml', Mage::helper('productslider')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action for this grid
     *
     * @return Mageplaza_ProductSlider_Block_Adminhtml_Productslider_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productslider_id');
        $this->getMassactionBlock()->setFormFieldName('productslider');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('productslider')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('productslider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productslider/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('productslider')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('productslider')->__('Status'),
                    'values' => $statuses
                ))
        ));
        return $this;
    }

    /**
     * get url for each row in grid
     *
     * @return string
     */

    protected function _filterStoreCondition($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (!is_null(@$value) && @$value != 0) {
            $collection->addFieldToFilter($column->getIndex(), array('finset' => $value));
        }
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid');
    }
}