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
 * Slider Form
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Slider Information'));
    }

    /**
     * Before toHtml
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _beforeToHtml()
    {
        $currentSlider = Mage::registry('current_slider');

        if ($currentSlider && $currentSlider->getId()) {

            $this->addTab('slides', array(
                'label'     => Mage::helper('antoinek_slider')->__('Associated Slides'),
                'class'     => 'ajax',
                'url'       => $this->getUrl('*/*/slides', array('_current' => true)),
            ));

        }

        $this->_updateActiveTab();
        return parent::_beforeToHtml();
    }

    /**
     * Update active tab
     */
    protected function _updateActiveTab()
    {
        $tabId = $this->getRequest()->getParam('tab');
        if( $tabId ) {
            $tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
            if($tabId) {
                $this->setActiveTab($tabId);
            }
        }
    }

// Antoine Kociuba Tag NEW_METHOD

}