<?php
namespace Movatech\AddOrderComment\Model\Rule;

use Movatech\AddOrderComment\Model\ResourceModel\Rule\Collection;
use Movatech\AddOrderComment\Model\ResourceModel\Rule\CollectionFactory;
use Movatech\AddOrderComment\Model\Rule;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $loadedData;
    protected $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
       // the code is intentionally left blank (as the repository used for demonstration purposes only)
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $rule) {
            $rule->load($rule->getId());
            $this->loadedData[$rule->getId()] = $rule->getData();
        }
        $data = $this->dataPersistor->get('mmaddordercomment_rule');
        if (!empty($data)) {
            $rule = $this->collection->getNewEmptyItem();
            $rule->setData($data);
            $this->loadedData[$rule->getId()] = $rule->getData();
            $this->dataPersistor->clear('mmaddordercomment_rule');
        }
        return $this->loadedData;
    }
}
