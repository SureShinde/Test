<?php

namespace Tychons\OutstockProducts\Plugin\CatalogSearch\Model\Search;

use Magento\Framework\DB\Select;
use Magento\Framework\Search\Request\FilterInterface;
use Magento\Framework\Search\Request\Filter\BoolExpression;
use Magento\Framework\Search\Request\Query\Filter;
use Magento\Framework\Search\RequestInterface;
use Magento\Framework\Search\Request\QueryInterface as RequestQueryInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\CatalogInventory\Helper\Stock;

class IndexBuilder
{

const XML_PATH_FOR_COMINGSOON_CATEGORY_ID = 'tychonsbulkpurchase/general/comingsoon_id';

/**
* @var \Magento\Framework\App\Config\ScopeConfigInterface
*/
protected $scopeConfig;

/**
* @var \Magento\Store\Model\StoreManagerInterface
*/
protected $storeManager;

protected $stockHelper;


public function __construct(
\Magento\Store\Model\StoreManagerInterface $storeManager,
\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
\Magento\Catalog\Model\Product\Visibility $productVisibility,
\Magento\Catalog\Helper\Category $categoryHelper,
\Magento\Framework\Registry $registry,
\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
\Tychons\OutstockProducts\Helper\Catalog\Stock $stockHelper
) {
$this->storeManager = $storeManager;
$this->_productCollectionFactory = $productCollectionFactory; 
$this->_productVisibility = $productVisibility;
$this->categoryHelper = $categoryHelper;
$this->registry = $registry;
$this->scopeConfig = $scopeConfig;
$this->stockHelper = $stockHelper;
}

/**
* Build index query
*
* @param $subject
* @param callable $proceed
* @param RequestInterface $request
* @return Select
* @SuppressWarnings(PHPMD.UnusedFormatParameter)
*/
   
public function aroundBuild($subject, callable $proceed, RequestInterface $request) {
    $select = $proceed($request);
    $storeId = $this->storeManager->getStore()->getStoreId();
    $rootCatId = $this->storeManager->getStore($storeId)->getRootCategoryId();
    $productUniqueIds = $this->getCustomCollectionQuery();
    $select->where('search_index.entity_id IN (' . join(',', $productUniqueIds) . ')');

    return $select;
}

/**
*
* @return ProductIds[]
*/
public function getCustomCollectionQuery() {
    $websiteId = $this->storeManager->getStore()->getWebsiteId();
    $collection = $this->_productCollectionFactory->create();
    $collection->addAttributeToSelect('*');
    $collection->addAttributeToSelect(array('entity_id','sku'));
    $collection->addWebsiteFilter($websiteId);
    $collection->setVisibility($this->_productVisibility->getVisibleInSiteIds());
    $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
    $comingSoonCategoryId = $this->scopeConfig->getValue(self::XML_PATH_FOR_COMINGSOON_CATEGORY_ID, $storeScope);
    $category = $this->registry->registry('current_category');
    if($category)
	{
		$catId = $category->getId();
		if($catId == $comingSoonCategoryId)
		{
    	$collection->joinField('stock_item', 'cataloginventory_stock_item', '*', 'product_id=entity_id', 'is_in_stock=0');
    	}
    	else
    	{
    	$collection=$this->stockHelper->customFilterOutOfStock($collection);
    	}
    }
    else
    {
	 	$collection->getSelect()
		->join(
        ['cataloginventory_stock_item'],
        'e.entity_id = cataloginventory_stock_item.product_id',
        []
        )->columns("cataloginventory_stock_item.is_in_stock")
		->join(
        ['catalog_category_product'],
        'e.entity_id = catalog_category_product.product_id',
        []
        )->columns("catalog_category_product.category_id")
		->where("catalog_category_product.category_id=615")
		->orWhere("cataloginventory_stock_item.is_in_stock = 1");
		$collection=$this->stockHelper->customFilterOutOfStock($collection);
    }

    $getProductAllIds = $collection->getAllIds();
    $getProductUniqueIds = array_unique($getProductAllIds);
    return $getProductUniqueIds;
}
}
