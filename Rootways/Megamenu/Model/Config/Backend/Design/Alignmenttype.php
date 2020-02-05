<?php
namespace Rootways\Megamenu\Model\Config\Backend\Design;

class Alignmenttype implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => __('From Left')],
            ['value' => '1', 'label' => __('From Right')],
            ['value' => '2', 'label' => __('Fit to Screen')]
        ];
    }
}
