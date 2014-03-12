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
 * Adminhtml_Source_Slider Model
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Adminhtml_Source_Slider
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $return = array();
        $sliders = Mage::getResourceModel('antoinek_slider/slider_collection');
        foreach($sliders as $slider) {
            $return[] = array(
                'value' => $slider->getId(),
                'label' => $slider->getTitle()
            );
        }

        return $return;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $sliders = Mage::getResourceModel('antoinek_slider/slider_collection');
        foreach($sliders as $slider) {
            $options[$slider->getId()] = $slider->getTitle();
        }

        return $options;
    }

// Antoine Kociuba Tag NEW_METHOD

}