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

//try {

    /* @var $installer Mage_Core_Model_Resource_Setup */
    $installer = $this;
    $installer->startSetup();

    /**
     * Create table 'antoinek_slider/slider'
     */
    $table = $installer->getConnection()
        ->newTable($installer->getTable('antoinek_slider/slider'))
        ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Slider Id')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => 0,
        ), 'Is Active')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Title')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Last Updated Time')
        ->addIndex($installer->getIdxName('antoinek_slider/slider', array('slider_id')),
            array('slider_id'))
        ->setComment('Sliders');
    $installer->getConnection()->createTable($table);

    /**
     * Create table 'antoinek_slider/slider_store'
     */
    $table = $installer->getConnection()
        ->newTable($installer->getTable('antoinek_slider/slider_store'))
        ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'primary'  => true,
            'unsigned'  => true,
            'nullable'  => false
        ), 'Slider Id')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'primary'  => true,
            'unsigned'  => true,
            'nullable'  => false
        ), 'Store Id')
        ->addIndex($installer->getIdxName('antoinek_slider/slider', array('slider_id')),
            array('slider_id'))
        ->addIndex($installer->getIdxName('antoinek_slider/slider', array('store_id')),
            array('store_id'))
        ->addForeignKey($installer->getFkName('antoinek_slider/slider_store', 'slider_id', 'antoinek_slider/slider', 'slider_id'),
            'slider_id', $installer->getTable('antoinek_slider/slider'), 'slider_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName('antoinek_slider/slider_store', 'store_id', 'core/store', 'store_id'),
            'store_id', $installer->getTable('core/store'), 'store_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Sliders/Store relations');
    $installer->getConnection()->createTable($table);

    /**
     * Create table 'antoinek_slider/slide'
     */
    $table = $installer->getConnection()
        ->newTable($installer->getTable('antoinek_slider/slide'))
        ->addColumn('slide_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Slide Id')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => 0,
        ), 'Is Active')
        ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Slider Id')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Title')
        ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => true
        ), 'Description')
        ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Image')
        ->addColumn('link', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
        ), 'Link')
        ->addColumn('link_url', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
        ), 'Link Url')
        ->addColumn('position', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array(
            'nullable'  => false,
            'default'   => 999,
        ), 'Slide Position')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Last Updated Time')
        ->addIndex($installer->getIdxName('antoinek_slider/slide', array('slide_id')),
            array('slide_id'))
        ->addIndex($installer->getIdxName('antoinek_slider/slide', array('slider_id')),
            array('slider_id'))
        ->addForeignKey($installer->getFkName('antoinek_slider/slide', 'slider_id', 'antoinek_slider/slider', 'slider_id'),
            'slider_id', $installer->getTable('antoinek_slider/slider'), 'slider_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Sliders Slides');
    $installer->getConnection()->createTable($table);

    $installer->endSetup();

//} catch (Exception $e) {
    // Silence is golden
    //Mage::logException($e);
//}
