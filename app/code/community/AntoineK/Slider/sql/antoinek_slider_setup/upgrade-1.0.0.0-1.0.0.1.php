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

try {

    /* @var $installer Mage_Core_Model_Resource_Setup */
    $installer = $this;
    $installer->startSetup();

    $installer->getConnection()->modifyColumn(
        $installer->getTable('antoinek_slider/slide'),
        'position',
        array(
            'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'nullable'  => false,
            'default'   => 999,
            'comment'   => 'Slide Position'
        )
    );

    $installer->endSetup();

} catch (Exception $e) {
    // Silence is golden
    Mage::logException($e);
}
