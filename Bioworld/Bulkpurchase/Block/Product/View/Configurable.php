<?php

namespace Bioworld\Bulkpurchase\Block\Product\View;

class Configurable extends \Bss\ConfigurableMatrixView\Block\Product\View\Configurable
{
    
    public function getStockQuantity($productId)
    {
        $stockRegistry = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\CatalogInventory\Api\StockRegistryInterface');
            $stockitem = $stockRegistry->getStockItem($productId);
        $stkQty=$stockitem->getData('qty');
        return $stkQty;
    }
}
