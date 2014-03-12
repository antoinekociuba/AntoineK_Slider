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
 * Slider Grid Container
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Constructor Override
     * @return AntoineK_Slider_Block_Adminhtml_Slider
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'antoinek_slider';
        $this->_controller = 'adminhtml_slider';
        $this->_headerText = $this->__('Grid of Sliders');
        $this->_addButtonLabel = $this->__('Add New Slider');

        return $this;
    }

    /**
     * Redefine header css class
     *
     * @return string
     */
    public function getHeaderCssClass() {
        return 'icon-head head-cms-page';
    }

// Antoine Kociuba Tag NEW_METHOD

}