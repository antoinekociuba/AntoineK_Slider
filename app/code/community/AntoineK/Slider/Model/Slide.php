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
 * Slide Model
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Slide extends Mage_Core_Model_Abstract
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'slide';

    /**
     * Parameter name in event
     * In observe method you can use $observer->getEvent()->getObject() in this case
     * @var string
     */
    protected $_eventObject = 'slide';

    /**
     * Slide Constructor
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('antoinek_slider/slide');
    }

    /**
     * Retrieve the image URL
     * @return string
     */
    public function getImageUrl()
    {
        return Mage::getBaseUrl('media') . $this->getImage();
    }

    /**
     * Retrieve the URL
     * @return string
     */
    public function getUrl()
    {
        return strtr($this->getData('link_url'), array(
            '{{baseUrl}}' => Mage::getUrl(),
            '{{baseSecureUrl}}' => Mage::getUrl('', array('_secure' => true)),
        ));
    }

// Antoine Kociuba Tag NEW_METHOD

}