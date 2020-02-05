<?php
namespace Rootways\Megamenu\Model\Attribute;

class Numberofcol extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '0', 'label' => __('Please Select')],
                ['value' => '1', 'label' => __('1')],
                ['value' => '2', 'label' => __('2')],
                ['value' => '3', 'label' => __('3')],
                ['value' => '4', 'label' => __('4')],
                ['value' => '5', 'label' => __('5')],
                ['value' => '6', 'label' => __('6')]
            ];
        }
        
        return $this->_options;
    }
}