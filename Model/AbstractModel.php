<?php
namespace Movatech\AddOrderComment\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;

abstract class AbstractModel extends \Magento\Framework\Model\AbstractExtensibleModel
{
    protected $form;
    protected $isDeleteable = true;
    protected $isReadonly = false;
    protected $serializer;
    protected $formFactory;
    protected $localeDate;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        ExtensionAttributesFactory $extensionFactory = null,
        AttributeValueFactory $customAttributeFactory = null,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null
    ) {
        $this->formFactory = $formFactory;
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()->get(
            \Magento\Framework\Serialize\Serializer\Json::class
        );
        parent::__construct(
            $context,
            $registry,
            $extensionFactory ?: $this->getExtensionFactory(),
            $customAttributeFactory ?: $this->getCustomAttributeFactory(),
            $resource,
            $resourceCollection,
            $data
        );
    }

// the code is intentionally left blank (as the repository used for demonstration purposes only)
}
