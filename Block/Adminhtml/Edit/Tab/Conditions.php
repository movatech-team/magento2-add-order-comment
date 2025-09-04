<?php
namespace Movatech\AddOrderComment\Block\Adminhtml\Edit\Tab;

class Conditions extends \Magento\Backend\Block\Widget\Container
{
    protected $_template = "Movatech_AddOrderComment::ordercomment/conditions.phtml";

    protected $registry;
    protected $attributeSetOptions;
    protected $serializer;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Catalog\Model\Product\AttributeSet\Options $attributeSetOptions,
        \Magento\Framework\Serialize\Serializer\Json $serializer,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->attributeSetOptions = $attributeSetOptions;
        $this->serializer = $serializer;
        parent::__construct($context, $data);
    }

    public function getConditionsJson()
    {
        $rule = $this->getRule();
        return $this->serializer->serialize($rule->getConditions());
    }

    public function getRuleId()
    {
        $catalogRule = $this->registry->registry('current_mmaddordercomment_rule');
        return $catalogRule ? $catalogRule->getId() : null;
    }

    public function getRule()
    {
        $catalogRule = $this->registry->registry('current_mmaddordercomment_rule');
        return $catalogRule ? $catalogRule : null;
    }

    public function getAttributeSetOptions()
    {
        return $this->serializer->serialize($this->attributeSetOptions->toOptionArray());
    }
}
