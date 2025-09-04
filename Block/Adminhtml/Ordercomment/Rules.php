<?php
namespace Movatech\AddOrderComment\Block\Adminhtml\Ordercomment;

class Rules extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Movatech_AddOrderComment';
        $this->_controller = 'adminhtml_mmaddordercomment_index';
        $this->_headerText = __('Add Order Comment');
        $this->_addButtonLabel = __('Add New Rule');
        parent::_construct();
    }
}
