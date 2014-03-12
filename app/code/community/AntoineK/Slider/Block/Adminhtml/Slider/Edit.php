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
 * Slider Form Container
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Constructor Override
     * @return AntoineK_Slider_Block_Adminhtml_Slider_Edit
     */
    protected function _construct()
    {
        $this->_blockGroup = 'antoinek_slider';
        $this->_controller = 'adminhtml_slider';
        $this->_mode       = 'edit';

        parent::_construct();

        $this->setFormActionUrl($this->getUrl('*/*/save', array('id' => $this->_getObject()->getId())));



        if($this->_getObject()->getId()){
            $this->_addButton('addslide', array(
                'label'     => Mage::helper('antoinek_slider')->__('Add New Slide'),
                'onclick'   => 'addSlide()',
                'class'     => 'add'
            ));

            $this->_formScripts[] = "
                function addSlide() {
                    slider_tabsJsTabs.tabs[1].show();
                    sliderAjaxFormPopup.open(
                        '".Mage::getUrl('adminhtml/slider_slider/popup')."',
                        ".$this->_getObject()->getId()."
                    );
                }
            ";
        }

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        return $this;
    }

    /**
     * The header
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_getObject()->getId()) {
            $header = 'Edit Slider';
        } else {
            $header = 'New Slider';
        }
        return $this->__($header);
    }

    /**
     * Retrieve current slider
     * @return AntoineK_Slider_Model_Slider
     */
    protected function _getObject()
    {
        return Mage::registry('current_slider');
    }

    /**
     * Redefine header css class
     *
     * @return string
     */
    public function getHeaderCssClass() {
        return 'icon-head head-cms-page';
    }

// Antoine Kociuba Tag NEW_METHOD

}