<?php
namespace Movatech\AddOrderComment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckoutSubmitAllAfter implements ObserverInterface
{
    private $collectionFactory;
    private $helper;

    public function __construct(
        \Movatech\AddOrderComment\Helper\Data $helper,
        \Movatech\AddOrderComment\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->helper = $helper;
    }

    public function execute(Observer $observer)
    {
        if (!$this->helper->isEnabled()) {
            return $this;
        }

        $rulesCollection = $this->collectionFactory->create()->getActiveRulesCollection();
        $order = $observer->getOrder();
        $orderComments = [];

        foreach ($rulesCollection as $rule) {
            $conditions = $rule->getConditions();
            $aggregator = $rule->getAggregator();

            foreach ($order->getAllVisibleItems() as $item) {
                $result = ($aggregator == 0) ? false : true;
                $productName = strtoupper(trim($item->getProduct()->getName()));
                foreach ($conditions as $condition) {
                    $condition['product_name'] = strtoupper(trim($condition['product_name']));
                    if ($condition['product_name'] != '' && $condition['attribute_set'] != '') {
                        if ($aggregator == 0) {
                            $result = $result || ((strpos($productName, $condition['product_name']) !== false) && ($item->getProduct()->getAttributeSetId() == $condition['attribute_set']));
                        } else {
                            $result = $result && ((strpos($productName, $condition['product_name']) !== false) && ($item->getProduct()->getAttributeSetId() == $condition['attribute_set']));
                        }
                    } elseif ($condition['product_name'] != '') {
                        if ($aggregator == 0) {
                            $result = $result || strpos($productName, $condition['product_name']) !== false;
                        } else {
                            $result = $result && strpos($productName, $condition['product_name']) !== false;
                        }
                    } else {
                        if ($aggregator == 0) {
                            $result = $result || $item->getProduct()->getAttributeSetId() == $condition['attribute_set'];
                        } else {
                            $result = $result && $item->getProduct()->getAttributeSetId() == $condition['attribute_set'];
                        }
                    }
                }
                if ($result) {
                    $orderComments[] = $rule->getComment();
                }
            }
        }

        if (count($orderComments)) {
            $history = $order->addStatusHistoryComment(implode(' ', $orderComments), $order->getStatus());
            $history->setIsVisibleOnFront(false);
            $history->setIsCustomerNotified(false);
            $history->save();
        }
        return $this;
    }
}
