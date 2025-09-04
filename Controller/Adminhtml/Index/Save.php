<?php
namespace Movatech\AddOrderComment\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    protected $dataPersistor;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        Date $dateFilter,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            $ruleRepository = $this->_objectManager->get(\Movatech\AddOrderComment\Api\AddOrderCommentRepositoryInterface::class);
            $model = $this->_objectManager->create(\Movatech\AddOrderComment\Model\Rule::class);
            try {
                $this->_eventManager->dispatch('adminhtml_controller_mmaddordercomment_prepare_save', ['request' => $this->getRequest()]);
                $data = $this->getRequest()->getPostValue();
                $id = $this->getRequest()->getParam('rule_id');
                if ($id) { $model = $ruleRepository->get($id); }
                $validateResult = $model->validateData(new \Magento\Framework\DataObject($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) { $this->messageManager->addErrorMessage($errorMessage); }
                    $this->_getSession()->setPageData($data);
                    $this->dataPersistor->set('mmaddordercomment_rule', $data);
                    $this->_redirect('mmaddordercomment/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $product_name  = $data['product_name'];
                $attribute_set = $data['attribute_set'];
                $conditions = [];
                foreach ($product_name as $key => $value) {
                    $conditions[] = [
                        'product_name'  => $product_name[$key],
                        'attribute_set' => $attribute_set[$key],
                    ];
                }
                unset($data['product_name']);
                unset($data['attribute_set']);
                $model->loadPost($data);
                $model->setConditions($conditions);
                $this->_objectManager->get(\Magento\Backend\Model\Session::class)->setPageData($data);
                $this->dataPersistor->set('mmaddordercomment_rule', $data);
                $ruleRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the rule.'));
                $this->_objectManager->get(\Magento\Backend\Model\Session::class)->setPageData(false);
                $this->dataPersistor->clear('mmaddordercomment_rule');
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('mmaddordercomment/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('mmaddordercomment/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the rule data. Please review the error log.'));
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
                $this->_objectManager->get(\Magento\Backend\Model\Session::class)->setPageData($data);
                $this->dataPersistor->set('mmaddordercomment_rule', $data);
                $this->_redirect('mmaddordercomment/*/edit', ['id' => $this->getRequest()->getParam('rule_id')]);
                return;
            }
        }
        $this->_redirect('mmaddordercomment/*/');
    }
}
