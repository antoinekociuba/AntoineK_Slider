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
 * Slider Model
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Slider extends Mage_Core_Model_Abstract
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'slider';

    /**
     * Parameter name in event
     * In observe method you can use $observer->getEvent()->getObject() in this case
     * @var string
     */
    protected $_eventObject = 'slider';

    /**
     * Slider Constructor
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('antoinek_slider/slider');
    }

    public function getSlides($activeOnly = false)
    {
        if (is_null($this->getData('slides'))) {
            $collection = Mage::getResourceModel('antoinek_slider/slide_collection')
                ->addSliderFilter($this->getId());

            if ($activeOnly) {
                $collection->addActiveFilter();
            }

            $this->setData('slides', $collection);
        }

        return $this->getData('slides');
    }

// Antoine Kociuba Tag NEW_METHOD

}