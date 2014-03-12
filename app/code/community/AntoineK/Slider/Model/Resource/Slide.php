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
 * Resource Model of Slide
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Resource_Slide extends Mage_Core_Model_Resource_Db_Abstract
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Slide Resource Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('antoinek_slider/slide', 'slide_id');
    }

    /**
     * Before save
     * @param Mage_Core_Model_Abstract $object
     * @return AntoineK_Slider_Model_Resource_Slider
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getId()) {
            $object->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setUpdatedAt(Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($object);
    }

// Antoine Kociuba Tag NEW_METHOD

}