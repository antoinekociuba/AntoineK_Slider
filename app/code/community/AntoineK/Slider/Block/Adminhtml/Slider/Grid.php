<?php
/**
 * This file is part of AntoineK_Slider for Magento.
 *
 * @license All rights reserved
 * @author Antoine Kociuba <antoine.kociuba@gmail.com>
 * @category AntoineK
 * @package AntoineK_Slider
 * @copyright Copyright (c) 2014 Antoine Kociuba (http://www.antoinekociuba.com)
 */

/**
 * Slider Grid
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('slider_grid');
        $this->setDefaultSort('slider_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Get collection object
     *
     * @return AntoineK_Slider_Model_Resource_Slider_Collection
     */
    public function getCollection()
    {
        if (!parent::getCollection()) {
            $collection = Mage::getResourceModel('antoinek_slider/slider_collection');
            $this->setCollection($collection);
        }

        return parent::getCollection();
    }

    /**
     * Prepare columns
     *
     * @return AntoineK_Slider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareColumns()
    {
        $help = Mage::helper('antoinek_slider');

        $this->addColumn('slider_id', array(
            'header'    => $help->__('ID'),
            'index'     => 'slider_id',
            'type'      => 'number',
        ));

        $this->addColumn('title', array(
            'header'    => $help->__('Title'),
            'type'      =>'text',
            'index'     => 'title',
        ));

        $this->addColumn('created_at', array(
            'header'   => Mage::helper('adminhtml')->__('Created At'),
            'type'     => 'datetime',
            'index'    => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'   => Mage::helper('adminhtml')->__('Updated At'),
            'type'     => 'datetime',
            'index'    => 'updated_at',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'                => Mage::helper('adminhtml')->__('Visible In'),
                'type'                  => 'store',
                'index'                 => 'store_id',
                'sortable'              => false,
                'store_all'             => true,
                'store_view'            => true,
                'width'                 => 200,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'sortable'  => false,
            'options'   => array(
                '1' => $help->__('Enabled'),
                '0' => $help->__('Disabled'),
            ),
            'frame_callback' => array($this, 'decorateStatus')
        ));

        return parent::_prepareColumns();
    }

    /**
     * Collection afterLoad
     *
     * @return $this|void
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Retrieve row edit URL
     *
     * @param AntoineK_Slider_Model_Slider $item
     * @return string
     */
    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }

    /**
     * Retrieve grid ajax URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/gridajax', array('_current'=> true));
    }

    /**
     * Decorate status column values
     *
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     * @return string
     */
    public function decorateStatus($value, $row, $column, $isExport)
    {
        if ((bool) $row->getIsActive()) {
            $class = 'grid-severity-notice';
        } else {
            $class = 'grid-severity-critical';
        }
        return '<span class="' . $class . '"><span>' . $value . '</span></span>';
    }

    /**
     * Store filter condition callback
     *
     * @param $collection
     * @param $column
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * Prepare mass actions
     *
     * @return $this|AntoineK_Slider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareMassaction()
    {
        $help = Mage::helper('antoinek_slider');

        $this->setMassactionIdField('slider_id');
        $this->getMassactionBlock()->setFormFieldName('slider');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> $help->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm' => $help->__('Are you sure?')
        ));

        $statuses = array(
            array(
                'value' => 0,
                'label' => $help->__('Disabled')
            ),
            array(
                'value' => 1,
                'label' => $help->__('Enabled')
            )
        );

        array_unshift($statuses, array('label'=>'', 'value'=>''));

        $this->getMassactionBlock()->addItem('status', array(
            'label'=> $help->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => $help->__('Status'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }

// Antoine Kociuba Tag NEW_METHOD

}