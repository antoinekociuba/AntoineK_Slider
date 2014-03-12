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
 * Adminhtml_Slider_Slide Controller
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Adminhtml_Slider_SlideController extends Mage_Adminhtml_Controller_Action
{

// Antoine Kociuba Tag NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Initialize slide
     *
     * @return AntoineK_Slider_Model_Slide
     */
    protected function _initSlide()
    {
        $slideId = (int) $this->getRequest()->getParam('id', false);
        $slide = Mage::getModel('antoinek_slider/slide')->load($slideId);
        Mage::register('current_slide', $slide);

        return $slide;
    }

    /**
     * Save slide
     * @return void
     */
    public function saveAction()
    {
        // Ajax param
        $isAjax     = $this->getRequest()->getParam('isAjax', false);

        // Object
        $object = $this->_initSlide();

        // Save it
        try {
            $object->addData($this->getRequest()->getPost('slide'));
            $object->save();
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);

            if($isAjax){
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setHttpResponseCode(500);
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array(
                    'error' => $this->__('An error occurred.')
                )));
                return;
            }

            $this->_getSession()->addError($this->__('An error occurred.'));
            $this->_redirectReferer();
            return;
        }

        // Success
        if($isAjax){
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array()));
            return;
        }

        $this->_getSession()->addSuccess($this->__('Slide successfully saved.'));

        // check if 'Save and Continue'
        if ($this->getRequest()->getParam('back')) {
            $this->_redirect('*/*/edit', array('id' => $object->getId()));
            return;
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Delete slide
     * @return void
     */
    public function deleteAction()
    {
        // Ajax param
        $isAjax     = $this->getRequest()->getParam('isAjax', false);

        // Object
        $object = $this->_initSlide();

        // No object?
        if (!$object->getId()) {

            if($isAjax){
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setHttpResponseCode(500);
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array(
                    'error' => $this->__('Slide not found.')
                )));
                return;
            }

            $this->_getSession()->addError($this->__('Slide not found.'));
            $this->_redirectReferer();
            return;
        }

        // Delete it
        try {
            $object->delete();
        } catch (Mage_Core_Exception $e) {

            if($isAjax){
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setHttpResponseCode(500);
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array(
                    'error' => $this->__('An error occurred.')
                )));
                return;
            }

            $this->_getSession()->addError($this->__('An error occurred.'));
            $this->_redirectReferer();
            return;
        }

        // Success
        if($isAjax){
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array()));
            return;
        }

        $this->_getSession()->addSuccess($this->__('Slide successfully deleted.'));
        $this->_redirect('*/*/index');
    }

    /**
     * Is allowed?
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/slider/slide');
    }

// Antoine Kociuba Tag NEW_METHOD

}