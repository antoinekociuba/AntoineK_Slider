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
 * Adminhtml_Slider_Slider Controller
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Adminhtml_Slider_SliderController extends Mage_Adminhtml_Controller_Action
{

// Antoine Kociuba NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Initialize slider
     *
     * @return AntoineK_Slider_Model_Slider
     */
    protected function _initSlider()
    {
        $sliderId = (int) $this->getRequest()->getParam('id', false);
        $slider = Mage::getModel('antoinek_slider/slider')->load($sliderId);
        Mage::register('current_slider', $slider);

        return $slider;
    }

    /**
     * Pre dispatch
     * @return void
     */
    public function preDispatch()
    {
        // Title
        $this->_title($this->__('Manage Slider'));

        return parent::preDispatch();
    }

    /**
     * List
     * @return void
     */
    public function indexAction()
    {
        $this->_forward('grid');
    }

    /**
     * Grid
     * @return void
     */
    public function gridAction()
    {
        // Layout
        $this->loadLayout();

        // Active Menu
        $this->_setActiveMenu('cms/slider');

        // Title
        $this->_title($this->__('Grid'));

        // Content
        $grid = $this->getLayout()->createBlock('antoinek_slider/adminhtml_slider', 'grid');
        $this->_addContent($grid);

        // Render
        $this->renderLayout();
    }

    /**
     * Grid Ajax
     * @return void
     */
    public function gridajaxAction()
    {
        // Layout
        $this->loadLayout();

        // Render
        $this->renderLayout();
    }

    /**
     * New slider
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit slider
     * @return void
     */
    public function editAction()
    {
        // Object
        $object = $this->_initSlider();

        // Layout
        $this->loadLayout();

        // Active Menu
        $this->_setActiveMenu('cms/slider');

        // Title
        if ($object->getId()) {
            $this->_title($this->__('Edit Slider'));
        } else {
            $this->_title($this->__('New Slider'));
        }

        // Render
        $this->renderLayout();
    }

    /**
     * Save slider
     * @return void
     */
    public function saveAction()
    {
        // Object
        $object = $this->_initSlider();

        // Save it
        try {
            $object->addData($this->getRequest()->getPost('slider'));
            $object->save();

            // Save slides position
            $slideIds = $this->getRequest()->getPost('slide');
            if (!empty($slideIds)) {
                foreach ($slideIds as $slideId => $slideData) {
                    $slide = Mage::getSingleton('antoinek_slider/slide')->load($slideId);
                    $slide->setPosition($slideData['position']);
                    $slide->save();
                }
            }

        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($this->__('An error occurred.'));
            $this->_redirectReferer();
            return;
        }

        // Success
        $this->_getSession()->addSuccess($this->__('Slider successfully saved.'));

        // check if 'Save and Continue'
        if ($this->getRequest()->getParam('back')) {
            $this->_redirect('*/*/edit', array('id' => $object->getId()));
            return;
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Delete slider
     * @return void
     */
    public function deleteAction()
    {
        // Object
        $object = $this->_initSlider();

        // No object?
        if (!$object->getId()) {
            $this->_getSession()->addError($this->__('Slider not found.'));
            $this->_redirectReferer();
            return;
        }

        // Delete it
        try {
            $object->delete();
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($this->__('An error occurred.'));
            $this->_redirectReferer();
            return;
        }

        // Success
        $this->_getSession()->addSuccess($this->__('Slider successfully deleted.'));
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            $this->_getSession()->addError($this->__('Please select slider(s).'));
        } else {
            if (!empty($sliderIds)) {
                try {
                    // TODO: optimize this...
                    $slider = Mage::getModel('antoinek_slider/slider');
                    foreach ($sliderIds as $sliderId) {
                        $currentSlider = clone $slider;
                        $currentSlider = $currentSlider->load($sliderId);
                        $currentSlider->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($sliderIds))
                    );
                } catch (Mage_Core_Model_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Exception $e) {
                    $this->_getSession()
                        ->addException($e, $this->__('An error occurred while deleting slider(s).'));
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Update slider(s) status action
     *
     */
    public function massStatusAction()
    {
        $sliderIds = (array) $this->getRequest()->getParam('slider');
        $status     = (int) $this->getRequest()->getParam('status');

        if (!is_array($sliderIds)) {
            $this->_getSession()->addError($this->__('Please select slider(s).'));
        } else {
            if (!empty($sliderIds)) {
                try {
                    // TODO: optimize this...
                    $slider = Mage::getModel('antoinek_slider/slider');
                    foreach ($sliderIds as $sliderId) {
                        $currentSlider = clone $slider;
                        $currentSlider = $currentSlider->load($sliderId);
                        $currentSlider->setIsActive($status);
                        $currentSlider->save();
                    }

                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been updated.', count($sliderIds))
                    );
                } catch (Mage_Core_Model_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Exception $e) {
                    $this->_getSession()
                        ->addException($e, $this->__('An error occurred while updating the slider(s) status.'));
                }
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Get slider associated slides
     *
     */
    public function slidesAction()
    {
        $this->_initSlider();
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Get slide form popup
     *
     */
    public function popupAction()
    {
        $sliderId = $this->getRequest()->getParam('slider_id', false);
        $slideId = $this->getRequest()->getParam('slide_id', false);

        $content = $this->getLayout()->createBlock('antoinek_slider/adminhtml_slide_edit_form', 'adminhtml_slider_slide_edit_form', array(
            'fieldset_legend' => false,
            'form_id' => 'slide_edit_form',
            'slider_id' => $sliderId,
            'slide_id' => $slideId,
            'action' => $this->getUrl('*/slider_slide/save', array('id' => $slideId))
        ));

        $this->getResponse()->setBody($content->toHtml());
    }



    /**
     * Is allowed?
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/slider/slider');
    }

// Antoine Kociuba Tag NEW_METHOD

}