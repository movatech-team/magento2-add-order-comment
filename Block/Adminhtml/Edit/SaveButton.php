<?php
namespace Movatech\AddOrderComment\Block\Adminhtml\Edit;

class SaveButton extends GenericButton implements \Magento\Ui\Component\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save Rule'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
