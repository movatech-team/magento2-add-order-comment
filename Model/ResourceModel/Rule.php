<?php
namespace Movatech\AddOrderComment\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Rule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const SECONDS_IN_DAY = 86400;

    protected $logger;
    protected $eventManager = null;
    protected $eavConfig;
    protected $storeManager;
    protected $entityManager;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Psr\Log\LoggerInterface $logger,
        $connectionName = null
    ) {
        $this->storeManager = $storeManager;
        $this->eavConfig = $eavConfig;
        $this->eventManager = $eventManager;
        $this->logger = $logger;
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init('addorder_rule', 'rule_id');
    }

    protected function _afterDelete(\Magento\Framework\Model\AbstractModel $rule)
    {
        $connection = $this->getConnection();
        $connection->delete($this->getTable('addorder_rule'), ['rule_id=?' => $rule->getId()]);
        return parent::_afterDelete($rule);
    }

    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        $this->getEntityManager()->load($object, $value);
        return $this;
    }

    public function save(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->getEntityManager()->save($object);
        return $this;
    }

    public function delete(AbstractModel $object)
    {
        $this->getEntityManager()->delete($object);
        return $this;
    }

    private function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Framework\EntityManager\EntityManager::class);
        }
        return $this->entityManager;
    }
}
