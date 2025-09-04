<?php
namespace Movatech\AddOrderComment\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Movatech Order Comment Rules'));
        $this->_view->renderLayout();
    }
}
