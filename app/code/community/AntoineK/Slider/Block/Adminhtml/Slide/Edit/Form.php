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
 * Slide Form
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Slide_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $help = Mage::helper('antoinek_slider');

        $form = new Varien_Data_Form(array(
            'id'        => ($this->getFormId()) ? $this->getFormId() : 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->setHtmlIdPrefix('slide_');
        $form->setFieldNameSuffix('slide');

        $entity = $this->_getCurrentSlide();

        $form->setDataObject($entity);

        $fieldset = $form->addFieldset('general', array(
            'legend' => (!is_null($this->getFieldsetLegend())) ? $this->getFieldsetLegend() : $help->__('General Information')
        ));

        if ($entity && $entity->getId()) {
            $fieldset->addField('slide_id', 'hidden', array(
                'name' => 'slide_id'
            ));
        }

        $fieldset->addField('slider_id', 'hidden', array(
            'name' => 'slider_id',
            'value' => $this->getSliderId()
        ));

        $fieldset->addType('mediachooser','AntoineK_MediaChooserField_Data_Form_Element_Mediachooser');

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => $help->__('Title'),
            'title' => $help->__('Title'),
            'required' => true
        ));

        $fieldset->addField('image', 'mediachooser', array(
            'name' => 'image',
            'label' => $help->__('Image'),
            'title' => $help->__('Image'),
            'required' => true
        ));

        $fieldset->addField('link', 'text', array(
            'name' => 'link',
            'label' => $help->__('Link'),
            'title' => $help->__('Link'),
            'required' => false
        ));

        $fieldset->addField('link_url', 'text', array(
            'name' => 'link_url',
            'label' => $help->__('Link Url'),
            'title' => $help->__('Link Url'),
            'required' => false,
            'note' => $help->__('You can use {{baseSecureUrl}} and {{baseUrl}} if needed.')
        ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('adminhtml')->__('Status'),
            'title' => Mage::helper('adminhtml')->__('Status'),
            'required' => true,
            'options'   => array(
                '1' => Mage::helper('cms')->__('Enabled'),
                '0' => Mage::helper('cms')->__('Disabled'),
            )
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Initialize form fields values
     * Method will be called after prepareForm and can be used for field values initialization
     * @return AntoineK_Slider_Block_Adminhtml_Slide_Edit_Form
     */
    protected function _initFormValues()
    {
        $entity = $this->_getCurrentSlide();
        if ($entity && $entity->getId()) {
            $this->getForm()->setValues($entity->getData());
        }

        return $this;
    }

    protected function _getCurrentSlide()
    {
        if($slideId = $this->getSlideId()) {
            $slideObject = Mage::getModel('antoinek_slider/slide')->load($slideId);
            Mage::register('current_slide', $slideObject);
            $this->setSlideId(null);
        }

        return Mage::registry('current_slide');
    }

// Antoine Kociuba Tag NEW_METHOD

}