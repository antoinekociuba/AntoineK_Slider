<?php
/**
 * This file is part of AntoineK_Slider for Magento.
 *
 * @license All rights reserved
 * @author Antoine Kociuba <antoine.kociuba@gmail.com>
 * @category AntoineK
 * @package AntoineK_Slider
 * @copyright Copyright (c) 2014 Antoine Kociuba (http://www.AntoineKociuba.com)
 */

/**
 * Collection of Slider
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Model_Resource_Slider_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Slider Collection Resource Constructor
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('antoinek_slider/slider');
        $this->_map['fields']['store']      = 'store_table.store_id';
        $this->_map['fields']['slider_id']  = 'main_table.slider_id';
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return AntoineK_Slider_Model_Resource_Slider_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $this->addFilter('store', array('in' => $store), 'public');
        }
        return $this;
    }

    /**
     * Add active filter
     * @param bool $active Active or not
     * @return AntoineK_Slider_Model_Resource_Slider_Collection
     */
    public function addActiveFilter($active = true)
    {
        $this->addFieldToFilter('is_active', $active);
        return $this;
    }

    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('antoinek_slider/slider_store')),
                'main_table.slider_id = store_table.slider_id',
                array()
            )->group('main_table.slider_id');

            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }

// Antoine Kociuba Tag NEW_METHOD

}