<?php
namespace Movatech\AddOrderComment\Block\Adminhtml\Edit;

class DeleteButton extends GenericButton implements \Magento\Ui\Component\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getRuleId()) {
            $data = [
                'label' => __('Delete Rule'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?') . '\', \'' .
                    $this->getUrl('*/*/delete', ['id' => $this->getRuleId()]) . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
}
