<?php
namespace Rootways\Megamenu\Model\Attribute;

class Domainmode implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => __('Development')],
            ['value' => '1', 'label' => __('Live')]
        ];
    }
    
    /*
    public function toArray()
    {
        return [
            'fullwidth' => __('Full Width'),
            'staticwidth' => __('Static Width'),
            'classic' => __('Classic')
        ];
    }
    */
}
