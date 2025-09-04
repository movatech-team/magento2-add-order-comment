<?php
namespace Movatech\AddOrderComment\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $ruleRepository = $this->_objectManager->get(\Movatech\AddOrderComment\Api\AddOrderCommentRepositoryInterface::class);
                $ruleRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the rule.'));
                $this->_redirect('mmaddordercomment/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t delete this rule right now. Please review the log and try again.'));
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
                $this->_redirect('mmaddordercomment/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a rule to delete.'));
        $this->_redirect('mmaddordercomment/*/');
    }
}
