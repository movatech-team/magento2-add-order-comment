<?php
namespace Movatech\AddOrderComment\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $coreRegistry = null;

    public function __construct(Context $context, Registry $coreRegistry)
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $ruleRepository = $this->_objectManager->get(\Movatech\AddOrderComment\Api\AddOrderCommentRepositoryInterface::class);
        if ($id) {
            try {
                $model = $ruleRepository->get($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists.'));
                $this->_redirect('mmaddordercomment/*');
                return;
            }
        } else {
            $model = $this->_objectManager->create(\Movatech\AddOrderComment\Model\Rule::class);
        }
        $data = $this->_objectManager->get(\Magento\Backend\Model\Session::class)->getPageData(true);
        if (!empty($data)) { $model->addData($data); }
        $model->setFormName('mmaddordercomment_rule_form');
        $this->coreRegistry->register('current_mmaddordercomment_rule', $model);
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Order Comment Rule'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend($model->getRuleId() ? $model->getName() : __('New Order Comment Rule'));
        $breadcrumb = $id ? __('Edit Rule') : __('New Rule');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
