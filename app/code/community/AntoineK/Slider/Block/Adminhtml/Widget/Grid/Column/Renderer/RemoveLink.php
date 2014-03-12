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
 * Widget Grid Column Renderer RemoveLink
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Widget_Grid_Column_Renderer_RemoveLink
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render Remove Link
     *
     * @access public
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $onclickJs = 'sliderAjaxFormPopup.deleteSlide(this.id'
            . ',\'' .Mage::getUrl('adminhtml/slider_slide/delete') . '\''
            . ',' . $row->getId().
        ');';

        $button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => $this->__('Delete Slide'),
            'class'     => 'delete',
            'onclick'   => $onclickJs
        ));

        return $button->toHtml();
    }
}
