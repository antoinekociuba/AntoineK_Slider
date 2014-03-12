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
 * Observer Model
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Observer extends Mage_Core_Model_Abstract
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Flush the media/slider/resized folder, when the catalog image cache is flushed
     *
     * @param Varien_Event_Observer $observer
     * @return Soon_Image_Model_Observer
     */
    public function cleanImageCache(Varien_Event_Observer $observer)
    {
        $directory = Mage::getBaseDir('media') . DS . 'slider' . DS . 'resized' . DS;
        $io = new Varien_Io_File();
        $io->rmdir($directory, true);

        return $this;
    }

// Antoine Kociuba Tag NEW_METHOD

}