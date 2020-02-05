<?php
namespace Rootways\Megamenu\Model\Config\Backend\Design;

class Dropdownanimation implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('None')],
            ['value' => 'topanimation', 'label' => __('From Top')],
            ['value' => 'bottomanimation', 'label' => __('From Bottom')],
            ['value' => 'rightanimation', 'label' => __('From Right')],
            ['value' => 'leftanimation', 'label' => __('From Left')]
        ];
    }
}
