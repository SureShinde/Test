<?php
namespace Rootways\Megamenu\Model\Attribute;

class Menutype extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
         if (!$this->_options) {
            $options = array();
             
            $options = [
                ['value' => '0', 'label' => __('Default')]
            ];
            
            $packageOption = array('label' => 'Dropdown Menu Type');
            $themeOptions = [
                ['value' => '1', 'label' => __('Simple dropdown')],
                ['value' => '2', 'label' => __('Dropdown With Mega Layout')],
                ['value' => '3', 'label' => __('Dropdown With Title')]
            ];
            $packageOption['value'] = $themeOptions;
            $options[] = $packageOption;
             
            $packageOption = array('label' => 'Half Width Menu Type');
            $themeOptions0 = [
                ['value' => '4', 'label' => __('Half width')],
                ['value' => '5', 'label' => __('Half width - with sub category as title')]
            ];
            $packageOption['value'] = $themeOptions0;
            $options[] = $packageOption;

            $packageOption = array('label' => 'Full Width Menu Type');
            $themeOptions1 = [
                ['value' => '6', 'label' => __('Full width')],
                ['value' => '7', 'label' => __('Half width - with sub category as title')]
            ];
            $packageOption['value'] = $themeOptions1;
            $options[] = $packageOption;

            $packageOption = array('label' => 'Tabbing Menu Type');
            $themeOptions2 = [
                ['value' => '8', 'label' => __('Tabbing menu')],
                ['value' => '9', 'label' => __('Tabbing - horizontal')]
            ];
            $packageOption['value'] = $themeOptions2;
            $options[] = $packageOption;

            $packageOption = array('label' => 'Product Menu Type');
            $themeOptions3 = [
                ['value' => '10', 'label' => __('Products only')]
            ];

            $packageOption['value'] = $themeOptions3;
            $options[] = $packageOption;

            $this->_options = $options;
            return $options;
        }
    }
}
