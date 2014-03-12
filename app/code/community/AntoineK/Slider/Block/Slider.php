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
 * Slider Block
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Slider extends Mage_Core_Block_Template
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Retrieve the cache key info
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'full_action_name' => Mage::app()->getFrontController()->getAction()->getFullActionName(),
            'name_in_layout'   => $this->getNameInLayout(),
            'store'            => Mage::app()->getStore()->getId(),
            'design_package'   => Mage::getDesign()->getPackageName(),
            'design_theme'     => Mage::getDesign()->getTheme('template'),
        );
    }

    /**
     * Retrieve the cache tags
     * @return array
     */
    public function getCacheTags()
    {
        $tags = parent::getCacheTags();
        array_push(
            $tags,
            AntoineK_Slider_Helper_Data::CACHE_TAG
        );

        return $tags;
    }

    /**
     * Retrieve the cache lifetime
     * @return int
     */
    public function getCacheLifetime()
    {
        return 7 * 24 * 3600;
    }

    /**
     * Prepare HTML
     * @return string
     */
    protected function _toHtml()
    {
        // If the slider Id is not specified
        if(!$sliderId = $this->getSliderId()){
            return null;
        }

        $slider = Mage::getModel('antoinek_slider/slider')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($sliderId);

        // If slider doesn't exist or is not active
        if (!$slider->getId() || !$slider->getIsActive()) {
            return null;
        }

        // Get active slides only
        $collection = $slider->getSlides(true);

        // If no slides
        if (!$collection->getSize()){
            return null;
        }

        // Order by position ASC
        $collection->setOrder('position', Varien_Data_Collection::SORT_ORDER_ASC);

        $this->setData('slider', $slider);

        return parent::_toHtml();
    }

// Antoine Kociuba Tag NEW_METHOD

}