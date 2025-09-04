<?php
/**
 * @category Movatech_AddOrderComment
 * @author Movatech Team
 * @copyright Copyright (c) 2019 Movatech
 * @package Movatech_AddOrderComment
 */

namespace Movatech\AddOrderComment\Api;

interface AddOrderCommentRepositoryInterface
{
    public function save(\Movatech\AddOrderComment\Api\Data\RuleInterface $rule);

    public function get($ruleId);

    public function delete(\Movatech\AddOrderComment\Api\Data\RuleInterface $rule);

    public function deleteById($ruleId);
}//end interface
