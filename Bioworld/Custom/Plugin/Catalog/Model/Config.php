<?php

namespace Bioworld\Custom\Plugin\Catalog\Model;

class Config
{
    public function afterGetAttributeUsedForSortByArray(
    \Magento\Catalog\Model\Config $catalogConfig,
    $options
    ) {
    	$options['position'] = __('Newest');
        $options['low_to_high'] = __('Price - Low To High');
        $options['high_to_low'] = __('Price - High To Low');
        return $options;

    }

}