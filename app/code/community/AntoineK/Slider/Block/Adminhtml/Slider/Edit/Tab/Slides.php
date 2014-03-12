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
 * Slider Tab
 * @package AntoineK_Slider
 */
class AntoineK_Slider_Block_Adminhtml_Slider_Edit_Tab_Slides extends Mage_Adminhtml_Block_Widget_Grid
{

// Antoine Kociuba NEW_CONST

// Antoine Kociuba Tag NEW_VAR

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('slide_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * After toHtml
     *
     * @param string $html
     * @return mixed|string
     */
    protected function _afterToHtml($html)
    {
        $html = parent::_afterToHtml($html);

        // Set a specific <tbody> id to be able to target children <tr>
        $html = str_replace("<tbody>", "<tbody id='slide_grid_tbody'>", $html);

        // Sortable JS template
        $html .= $this->getLayout()->createBlock('core/template')->setTemplate('antoinek/slider/js.phtml')->toHtml();

        return $html;
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_getCurrentSlider()->getSlides();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Get current slider
     *
     * @return AntoineK_Slider_Model_Slider
     */
    protected function _getCurrentSlider()
    {
        return Mage::registry('current_slider');
    }

    /**
     * Prepare Columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $help = Mage::helper('antoinek_slider');

        $this->addColumn('slide_id', array(
            'header'    => $help->__('ID'),
            'index'     => 'slide_id',
            'type'      => 'number',
        ));

        $this->addColumn('image', array(
            'header'   => $help->__('Image'),
            'type'     => 'text',
            'index'    => 'image',
            'align'    =>'center',
            'filter'   => false,
            'sortable' => false,
            'frame_callback' => array($this, 'decorateImage')
        ));

        $this->addColumn('title', array(
            'header'    => $help->__('Title'),
            'type'      =>'text',
            'index'     => 'title',
        ));

        $this->addColumn('created_at', array(
            'header'   => Mage::helper('adminhtml')->__('Created At'),
            'type'     => 'datetime',
            'index'    => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'   => Mage::helper('adminhtml')->__('Updated At'),
            'type'     => 'datetime',
            'index'    => 'updated_at',
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'sortable'  => false,
            'options'   => array(
                '1' => Mage::helper('cms')->__('Enabled'),
                '0' => Mage::helper('cms')->__('Disabled'),
            ),
            'frame_callback' => array($this, 'decorateStatus')
        ));

        $this->addColumn('position', array(
            'header'    => $help->__('Sort'),
            'filter' => false,
            'index'     => 'position',
            'align'    =>'center',
            'frame_callback' => array($this, 'decoratePosition')
        ));

        $this->addColumn('edit', array(
            'header'    => $help->__('Edit'),
            'width'     => '50px',
            'type'      => 'text',
            'sortable' => false,
            'renderer' => 'AntoineK_Slider_Block_Adminhtml_Widget_Grid_Column_Renderer_EditLink',
        ));

        $this->addColumn('remove', array(
            'header'    => $help->__('Delete'),
            'width'     => '50px',
            'type'      => 'text',
            'sortable' => false,
            'renderer' => 'AntoineK_Slider_Block_Adminhtml_Widget_Grid_Column_Renderer_RemoveLink',
        ));

        return parent::_prepareColumns();
    }


    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/slides', array('_current'=>true));
    }

    /**
     * Decorate status column values
     *
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     * @return string
     */
    public function decorateStatus($value, $row, $column, $isExport)
    {
        if ((bool) $row->getIsActive()) {
            $class = 'grid-severity-notice';
        } else {
            $class = 'grid-severity-critical';
        }
        return '<span class="' . $class . '"><span>' . $value . '</span></span>';
    }

    /**
     * Decorate position column values
     *
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     * @return string
     */
    public function decoratePosition($value, $row, $column, $isExport)
    {
        return '<div class="ak-sort-el">'
            . '<img title="'. Mage::helper('antoinek_slider')->__('Sort by Drag and Drop') . '" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAJ42lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNC4yLjItYzA2MyA1My4zNTI2MjQsIDIwMDgvMDcvMzAtMTg6MTI6MTggICAgICAgICI+CiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iCiAgICB4bWxuczpJcHRjNHhtcENvcmU9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBDb3JlLzEuMC94bWxucy8iCiAgICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgICB4bWxuczp4bXBSaWdodHM9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9yaWdodHMvIgogICAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIgogICAgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iCiAgICB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIgogICBwaG90b3Nob3A6RGF0ZUNyZWF0ZWQ9IjIwMTAtMDEtMDEiCiAgIHBob3Rvc2hvcDpDcmVkaXQ9Ind3dy5nZW50bGVmYWNlLmNvbSIKICAgcGhvdG9zaG9wOkF1dGhvcnNQb3NpdGlvbj0iQXJ0IERpcmVjdG9yIgogICBJcHRjNHhtcENvcmU6SW50ZWxsZWN0dWFsR2VucmU9InBpY3RvZ3JhbSIKICAgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxMC0wMS0wM1QyMTozMzo0MyswMTowMCIKICAgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1NEI4QjM0OEE3RjhERTExODIxQ0U0QjJDN0UzNkQ3MCIKICAgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1NEI4QjM0OEE3RjhERTExODIxQ0U0QjJDN0UzNkQ3MCIKICAgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjU0QjhCMzQ4QTdGOERFMTE4MjFDRTRCMkM3RTM2RDcwIj4KICAgPElwdGM0eG1wQ29yZTpDcmVhdG9yQ29udGFjdEluZm8KICAgIElwdGM0eG1wQ29yZTpDaUFkckNpdHk9IlByYWd1ZSIKICAgIElwdGM0eG1wQ29yZTpDaUFkclBjb2RlPSIxNjAwMCIKICAgIElwdGM0eG1wQ29yZTpDaUFkckN0cnk9IkN6ZWNoIFJlcHVibGljIgogICAgSXB0YzR4bXBDb3JlOkNpRW1haWxXb3JrPSJrYUBnZW50bGVmYWNlLmNvbSIKICAgIElwdGM0eG1wQ29yZTpDaVVybFdvcms9Ind3dy5nZW50bGVmYWNlLmNvbSIvPgogICA8ZGM6cmlnaHRzPgogICAgPHJkZjpBbHQ+CiAgICAgPHJkZjpsaSB4bWw6bGFuZz0ieC1kZWZhdWx0Ij5DcmVhdGl2ZSBDb21tb25zIEF0dHJpYnV0aW9uIE5vbi1Db21tZXJjaWFsIE5vIERlcml2YXRpdmVzPC9yZGY6bGk+CiAgICA8L3JkZjpBbHQ+CiAgIDwvZGM6cmlnaHRzPgogICA8ZGM6Y3JlYXRvcj4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGk+QWxleGFuZGVyIEtpc2VsZXY8L3JkZjpsaT4KICAgIDwvcmRmOlNlcT4KICAgPC9kYzpjcmVhdG9yPgogICA8ZGM6ZGVzY3JpcHRpb24+CiAgICA8cmRmOkFsdD4KICAgICA8cmRmOmxpIHhtbDpsYW5nPSJ4LWRlZmF1bHQiPlRoaXMgaXMgdGhlIGljb24gZnJvbSBHZW50bGVmYWNlLmNvbSBmcmVlIGljb25zIHNldC4gPC9yZGY6bGk+CiAgICA8L3JkZjpBbHQ+CiAg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" />'
            . '<input type="hidden" name="slide['.$row->getId().'][position]" value="' . $value . '">'
            . '</div>';
    }

    /**
     * Decorate image column values
     *
     * @param $value
     * @param $row
     * @param $column
     * @param $isExport
     * @return string
     */
    public function decorateImage($value, $row, $column, $isExport)
    {
        $resizedImage = Mage::helper('antoinek_slider')->resize($row->getImage(), 60);
        return sprintf('<img src="%s"/>', $resizedImage);
    }

// Antoine Kociuba Tag NEW_METHOD

}
