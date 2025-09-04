<?php
namespace Movatech\AddOrderComment\Block\Adminhtml\Edit;

class SaveAndContinueButton extends GenericButton implements \Magento\Ui\Component\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'saveAndContinueEdit']],
            ],
            'sort_order' => 80,
        ];
    }
}
