<?php
namespace Movatech\AddOrderComment\Block\Adminhtml\Edit;

class ResetButton extends GenericButton implements \Magento\Ui\Component\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 70,
        ];
    }
}
