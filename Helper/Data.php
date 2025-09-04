<?php
namespace Movatech\AddOrderComment\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const CONFIG_MODULE_ENABLED = 'mmaddordercomment/order_comment/enable';

    public function isEnabled($scopeCode = null)
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_MODULE_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $scopeCode);
    }
}
