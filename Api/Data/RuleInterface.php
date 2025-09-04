<?php
/**
 * @category Movatech_AddOrderComment
 * @author Movatech
 */

namespace Movatech\AddOrderComment\Api\Data;

interface RuleInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**
     * Constants defined for keys of data array
     */
    public const RULE_ID = 'rule_id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const IS_ACTIVE = 'is_active';
    public const COMMENT = 'comment';
    public const CONDITION = 'conditions_serialized';
    public const AGGREGATOR = 'aggregator';
    public const AGGREGATOR_AND = 1;
    public const AGGREGATOR_OR = 0;
    public const ACTIVE = 1;

    /**
     * Returns rule id field
     * @return int|null
     */
    public function getRuleId();

    /**
     * @param int $ruleId
     * @return $this
     */
    public function setRuleId($ruleId);

    /**
     * Returns rule name
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Returns rule description
     * @return string|null
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Returns rule activity flag
     * @return int
     */
    public function getIsActive();

    /**
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Returns serialized rule condition
     * @return string|null
     */
    public function getConditionsSerialized();

    /**
     * @param string $condition
     * @return $this
     */
    public function setConditionsSerialized($condition);

    /**
     * Returns rule order comment
     * @return string|null
     */
    public function getComment();

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment);

    /**
     * Returns rule conditions aggregator
     * @return int|null
     */
    public function getAggregator();

    /**
     * @param int $aggregator
     * @return $this
     */
    public function setAggregator($aggregator);
}
