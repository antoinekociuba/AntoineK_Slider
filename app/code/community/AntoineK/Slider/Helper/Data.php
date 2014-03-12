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
 * Data Helper
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Cache tag
     * @const CACHE_TAG string
     */
    const CACHE_TAG = 'antoinek_slider';

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Resize image method
     *
     * @param $fileName string
     * @param $width int
     * @param $height null|int
     * @return string
     */
    public function resize($fileName, $width, $height = null)
    {
        $heightPath = (is_null($height)) ? 0 : $height;

        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;

        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $fileName;
        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "slider" . DS . "resized" . DS . $width . DS . $heightPath . DS . $fileName;
        //if width empty then return original size image's URL
        if ($width != '') {
            //if image has already resized then just return URL
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(true);
                $imageObj->keepAspectRatio(false);
                $imageObj->keepFrame(false);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }
            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "slider" . DS . "resized" . DS . $width . DS . $heightPath . DS . $fileName;
        } else {
            $resizedURL = $imageURL;
        }

        // Windows DS fix
        if (DS == '\\') {
            $resizedURL = str_replace('\\', '/', $resizedURL);
        }

        return $resizedURL;
    }

// Antoine Kociuba Tag NEW_METHOD

}