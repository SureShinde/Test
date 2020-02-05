<?php

namespace Tychons\OutstockProducts\Helper\Catalog;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;
use Magento\CatalogInventory\Api\StockConfigurationInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock\Status;
use Magento\CatalogInventory\Model\ResourceModel\Stock\StatusFactory;
use Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class Stock extends \Magento\CatalogInventory\Helper\Stock
{    

    const XML_PATH_FOR_COMINGSOON_CATEGORY_ID = 'tychonsbulkpurchase/general/comingsoon_id';

    public function __construct(
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        StatusFactory $stockStatusFactory,
        StockRegistryProviderInterface $stockRegistryProvider
    ) {
        parent::__construct(
            $storeManager,
            $scopeConfig,
            $stockStatusFactory,
            $stockRegistryProvider
        );
    }
   
    public function customFilterOutOfStock($collection)
    {
        $stockFlag = 'has_stock_status_filter';

        if (!$collection->hasFlag($stockFlag)) {
            $isShowOutOfStock = $this->scopeConfig->getValue(
                \Magento\CatalogInventory\Model\Configuration::XML_PATH_SHOW_OUT_OF_STOCK,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            $resource = $this->getStockStatusResource();
            $resource->addStockDataToCollection(
                $collection,
                $isShowOutOfStock
            );
            $collection->setFlag($stockFlag, true);
        }
        return $collection;   
    }
}
?>