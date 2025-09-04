<?php
namespace Movatech\AddOrderComment\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class NewAction extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
