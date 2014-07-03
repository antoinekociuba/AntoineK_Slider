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
 * Adminhtml Widget Chooser Block
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Widget_Chooser extends Mage_Adminhtml_Block_Widget_Grid
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Block construction, prepare grid params
     *
     * @param array $arguments Object data
     */
    public function __construct($arguments=array())
    {
        parent::__construct($arguments);
        $this->setDefaultSort('chooser_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('chooser_is_active' => '1'));
    }

    /**
     * Prepare chooser element HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/slider_slider/chooser', array('uniq_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        if ($element->getValue()) {
            $block = Mage::getModel('antoinek_slider/slider')->load($element->getValue());
            if ($block->getId()) {
                $chooser->setLabel($block->getTitle());
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var sliderId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var sliderTitle = trElement.down("td").next().innerHTML;
                '.$chooserJsObject.'.setElementValue(sliderId);
                '.$chooserJsObject.'.setElementLabel(sliderTitle);
                '.$chooserJsObject.'.close();
            }
        ';
        return $js;
    }

    /**
     * Prepare Slider collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('antoinek_slider/slider')->getCollection();
        /* @var $collection AntoineK_Slider_Model_Resource_Slider_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for Slider grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $help = Mage::helper('antoinek_slider');

        $this->addColumn('chooser_id', array(
            'header'    => $help->__('ID'),
            'align'     => 'right',
            'index'     => 'slider_id',
            'width'     => 50
        ));

        $this->addColumn('chooser_title', array(
            'header'    => $help->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('chooser_store_id', array(
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

        $this->addColumn('chooser_is_active', array(
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
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/slider_slider/chooser', array('_current' => true));
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
     * Collection afterLoad
     *
     * @return $this|void
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

// Antoine Kociuba Tag NEW_METHOD

}