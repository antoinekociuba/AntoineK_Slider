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
 * Collection of Slide
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Resource_Slide_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Slide Collection Resource Constructor
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('antoinek_slider/slide');
    }

    /**
     * Add slider filter
     *
     * @param mixed $sliderId
     * @param boolean $exclude
     * @return AntoineK_Slider_Model_Resource_Slide_Collection
     */
    public function addSliderFilter($sliderId, $exclude = false)
    {
        if (empty($sliderId)) {
            $this->_setIsLoaded(true);
            return $this;
        }
        if (is_array($sliderId)) {
            if (!empty($sliderId)) {
                if ($exclude) {
                    $condition = array('nin' => $sliderId);
                } else {
                    $condition = array('in' => $sliderId);
                }
            } else {
                $condition = '';
            }
        } else {
            if ($exclude) {
                $condition = array('neq' => $sliderId);
            } else {
                $condition = $sliderId;
            }
        }
        $this->addFieldToFilter('slider_id', $condition);
        return $this;
    }

    /**
     * Add active filter
     * @param bool $active Active or not
     * @return AntoineK_Slider_Model_Resource_Slide_Collection
     */
    public function addActiveFilter($active = true)
    {
        $this->addFieldToFilter('is_active', $active);
        return $this;
    }

// Antoine Kociuba Tag NEW_METHOD

}