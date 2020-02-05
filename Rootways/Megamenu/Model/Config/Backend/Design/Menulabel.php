<?php
namespace Rootways\Megamenu\Model\Config\Backend\Design;

class Menulabel implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'none', 'label' => __('Normal')],
            ['value' => 'uppercase', 'label' => __('Uppercase')],
            ['value' => 'lowercase', 'label' => __('Lowercase')],
            ['value' => 'capitalize', 'label' => __('Capitalize')]
        ];
    }
}
