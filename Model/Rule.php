<?php
namespace Movatech\AddOrderComment\Model;

use Movatech\AddOrderComment\Model\ResourceModel\Rule as RuleResourceModel;
use Movatech\AddOrderComment\Api\Data\RuleInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Model\ResourceModel\Iterator;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;

class Rule extends \Movatech\AddOrderComment\Model\AbstractModel implements RuleInterface
{
    protected $eventPrefix = 'mmaddordercomment_rule';
    protected $eventObject = 'rule';

    protected $catalogRuleData;
    protected $cacheTypesList;
    protected $relatedCacheTypes;
    protected $resourceIterator;
    protected $customerSession;
    protected $storeManager;
    protected $ruleConditionConverter;
    protected $serializer;
    private $conditions;
    private $ruleResourceModel;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        StoreManagerInterface $storeManager,
        Iterator $resourceIterator,
        Session $customerSession,
        TypeListInterface $cacheTypesList,
        RuleResourceModel $ruleResourceModel,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $relatedCacheTypes = [],
        array $data = [],
        ExtensionAttributesFactory $extensionFactory = null,
        AttributeValueFactory $customAttributeFactory = null,
        Json $serializer = null
    ) {
        $this->storeManager = $storeManager;
        $this->resourceIterator = $resourceIterator;
        $this->customerSession = $customerSession;
        $this->cacheTypesList = $cacheTypesList;
        $this->relatedCacheTypes = $relatedCacheTypes;
        $this->ruleResourceModel = $ruleResourceModel;
        $this->serializer = $serializer;

        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $resource,
            $resourceCollection,
            $data,
            $extensionFactory,
            $customAttributeFactory,
            $serializer
        );
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_init(RuleResourceModel::class);
        $this->setIdFieldName('rule_id');
    }

    protected function _invalidateCache()
    {
        if (count($this->relatedCacheTypes)) {
            $this->cacheTypesList->invalidate($this->relatedCacheTypes);
        }
        return $this;
    }

    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    public function getRuleId() { return $this->getData(self::RULE_ID); }
    public function setRuleId($ruleId) { return $this->setData(self::RULE_ID, $ruleId); }
    public function getName() { return $this->getData(self::NAME); }
    public function setName($name) { return $this->setData(self::NAME, $name); }
    public function getDescription() { return $this->getData(self::DESCRIPTION); }
    public function setDescription($description) { return $this->setData(self::DESCRIPTION, $description); }
    public function getIsActive() { return $this->getData(self::IS_ACTIVE); }
    public function setIsActive($isActive) { return $this->setData(self::IS_ACTIVE, $isActive); }
    public function getConditionsSerialized() { return $this->getData(self::CONDITION); }
    public function setConditionsSerialized($condition) { return $this->setData(self::CONDITION, $condition); }
    public function getAggregator() { return $this->getData(self::AGGREGATOR); }
    public function setAggregator($aggregator) { return $this->setData(self::AGGREGATOR, $aggregator); }
    public function getComment() { return $this->getData(self::COMMENT); }
    public function setComment($comment) { return $this->setData(self::COMMENT, $comment); }

    // the code is intentionally left blank (as the repository used for demonstration purposes only)
}
