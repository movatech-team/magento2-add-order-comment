<?php
namespace Movatech\AddOrderComment\Model;

use Movatech\AddOrderComment\Api\Data;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;

class AddOrderCommentRuleRepository implements \Movatech\AddOrderComment\Api\AddOrderCommentRepositoryInterface
{
    protected $ruleResource;
    protected $ruleFactory;
    private $rules = [];

    public function __construct(
        \Movatech\AddOrderComment\Model\ResourceModel\Rule $ruleResource,
        \Movatech\AddOrderComment\Model\RuleFactory $ruleFactory
    ) {
        $this->ruleResource = $ruleResource;
        $this->ruleFactory = $ruleFactory;
    }

    public function save(Data\RuleInterface $rule)
    {
        if ($rule->getRuleId()) {
            $rule = $this->get($rule->getRuleId())->addData($rule->getData());
        }
        try {
            $this->ruleResource->save($rule);
            unset($this->rules[$rule->getId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('The "%1" rule was unable to be saved. Please try again.', $rule->getId()));
        }
        return $rule;
    }

    public function get($ruleId)
    {
        if (!isset($this->rules[$ruleId])) {
            $rule = $this->ruleFactory->create();
            $rule->load($ruleId);
            if (!$rule->getRuleId()) {
                throw new NoSuchEntityException(__('The rule with the "%1" ID wasn\'t found. Verify the ID and try again.', $ruleId));
            }
            $this->rules[$ruleId] = $rule;
        }
        return $this->rules[$ruleId];
    }

    public function delete(Data\RuleInterface $rule)
    {
        try {
            $this->ruleResource->delete($rule);
            unset($this->rules[$rule->getId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('The "%1" rule couldn\'t be removed.', $rule->getRuleId()));
        }
        return true;
    }

    public function deleteById($ruleId)
    {
        $model = $this->get($ruleId);
        $this->delete($model);
        return true;
    }
}
