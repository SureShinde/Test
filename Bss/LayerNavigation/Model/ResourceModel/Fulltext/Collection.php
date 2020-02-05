<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category  BSS
 * @package   Bss_LayerNavigation
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 BSS Commerce Co. ( http://bsscommerce.com )
 * @license   http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\LayerNavigation\Model\ResourceModel\Fulltext;

use Magento\CatalogSearch\Model\Search\RequestGenerator;
use Magento\Framework\DB\Select;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Search\Adapter\Mysql\TemporaryStorage;

/**
 * Class Collection
 * @package Bss\LayerNavigation\Model\ResourceModel\Fulltext
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Collection
{
    /**
     * @var null
     */
    public $collectionClone = null;

    /**
     * @var
     */
    private $queryText;

    /**
     * @var null
     */
    private $order = null;

    /**
     * @var string
     */
    private $searchRequestName;

    /**
     * @var \Magento\Framework\Search\Adapter\Mysql\TemporaryStorageFactory
     */
    private $temporaryStorageFactory;

    /**
     * @var
     */
    private $search;

    /**
     * @var
     */
    private $searchCriteriaBuilder;

    /**
     * @var
     */
    private $searchResult;

    /**
     * @var
     */
    private $filterBuilder;

    /**
     * @var \Magento\Search\Api\SearchInterface
     */
    private $searchInterface;

    /**
     * @var \Bss\LayerNavigation\Model\Search\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilderBss;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    private $filterBuilderApi;

    /**
     * Collection constructor.
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Eav\Model\EntityFactory $eavEntityFactory
     * @param \Magento\Catalog\Model\ResourceModel\Helper $resourceHelper
     * @param \Magento\Framework\Validator\UniversalFactory $universalFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Catalog\Model\Indexer\Product\Flat\State $catalogProductFlatState
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Url $catalogUrl
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param \Magento\Customer\Api\GroupManagementInterface $groupManagement
     * @param \Magento\Framework\Search\Adapter\Mysql\TemporaryStorageFactory $temporaryStorageFactory
     * @param \Magento\Search\Api\SearchInterface $searchInterface
     * @param \Bss\LayerNavigation\Model\Search\SearchCriteriaBuilder $searchCriteriaBuilderBss
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilderApi
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param string $searchRequestName
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\EntityFactory $eavEntityFactory,
        \Magento\Catalog\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Model\Indexer\Product\Flat\State $catalogProductFlatState,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory,
        \Magento\Catalog\Model\ResourceModel\Url $catalogUrl,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Customer\Api\GroupManagementInterface $groupManagement,
        \Magento\Framework\Search\Adapter\Mysql\TemporaryStorageFactory $temporaryStorageFactory,
        \Magento\Search\Api\SearchInterface $searchInterface,
        \Bss\LayerNavigation\Model\Search\SearchCriteriaBuilder $searchCriteriaBuilderBss,
        \Magento\Framework\Api\FilterBuilder $filterBuilderApi,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        $searchRequestName = 'catalog_view_container'
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $eavConfig,
            $resource,
            $eavEntityFactory,
            $resourceHelper,
            $universalFactory,
            $storeManager,
            $moduleManager,
            $catalogProductFlatState,
            $scopeConfig,
            $productOptionFactory,
            $catalogUrl,
            $localeDate,
            $customerSession,
            $dateTime,
            $groupManagement,
            $connection
        );
        $this->temporaryStorageFactory = $temporaryStorageFactory;
        $this->searchRequestName = $searchRequestName;
        $this->searchInterface = $searchInterface;
        $this->searchCriteriaBuilderBss = $searchCriteriaBuilderBss;
        $this->filterBuilderApi = $filterBuilderApi;
    }

    /**
     * @return Collection|null
     */
    public function getCollectionClone()
    {
        if ($this->collectionClone === null) {
            $this->collectionClone = clone $this;
            $this->collectionClone->setSearchCriteriaBuilder($this->searchCriteriaBuilder->cloneObject());
        }

        $searchCriterialBuilder = $this->collectionClone->getSearchCriteriaBuilder()->cloneObject();
        $collectionClone = clone $this->collectionClone;
        $collectionClone->setSearchCriteriaBuilder($searchCriterialBuilder);

        return $collectionClone;
    }

    /**
     * @param $categories
     * @return $this
     */
    public function addLayerCategoryFilter($categories)
    {
        if (count($categories) > 1) {
            $this->addFieldToFilter('category_ids', ['in' => $categories]);
        } else {
            $this->addFieldToFilter('category_ids', $categories[0]);
        }
        return $this;
    }

    /**
     * @param $attributeCode
     * @return $this
     */
    public function removeAttributeSearch($attributeCode)
    {
        if (is_array($attributeCode)) {
            foreach ($attributeCode as $attCode) {
                $this->searchCriteriaBuilder->removeFilter($attCode);
            }
        } else {
            $this->searchCriteriaBuilder->removeFilter($attributeCode);
        }

        $this->_isFiltersRendered = false;
        return $this->loadWithFilter();
    }

    /**
     * @param $attribute
     * @param $condition
     * @param string $joinType
     * @return string
     */
    public function getAttributeConditionSql($attribute, $condition, $joinType = 'inner')
    {
        return $this->_getAttributeConditionSql($attribute, $condition, $joinType);
    }

    /**
     * @return $this
     */
    public function resetTotalRecords()
    {
        $this->_totalRecords = null;

        return $this;
    }

    /**
     * @return mixed
     */
    private function getSearch()
    {
        if ($this->search === null) {
            $this->search = $this->searchInterface;
        }

        return $this->search;
    }

    /**
     * @param \Magento\Search\Api\SearchInterface $object
     */
    public function setSearch(\Magento\Search\Api\SearchInterface $object)
    {
        $this->search = $object;
    }

    /**
     * @return mixed
     */
    public function getSearchCriteriaBuilder()
    {
        if ($this->searchCriteriaBuilder === null) {
            $this->searchCriteriaBuilder = $this->searchCriteriaBuilderBss;
        }

        return $this->searchCriteriaBuilder;
    }

    /**
     * @param \Bss\LayerNavigation\Model\Search\SearchCriteriaBuilder $object
     */
    public function setSearchCriteriaBuilder(\Bss\LayerNavigation\Model\Search\SearchCriteriaBuilder $object)
    {
        $this->searchCriteriaBuilder = $object;
    }

    /**
     * @return mixed
     */
    private function getFilterBuilder()
    {
        if ($this->filterBuilder === null) {
            $this->filterBuilder = $this->filterBuilderApi;
        }

        return $this->filterBuilder;
    }

    /**
     * @param \Magento\Framework\Api\FilterBuilder $object
     */
    public function setFilterBuilder(\Magento\Framework\Api\FilterBuilder $object)
    {
        $this->filterBuilder = $object;
    }

    /**
     * @param mixed $field
     * @param null $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($this->searchResult !== null) {
            throw new \RuntimeException('Illegal state');
        }

        $this->getSearchCriteriaBuilder();
        $this->getFilterBuilder();
        if (!is_array($condition) || !in_array(key($condition), ['from', 'to'])) {
            $this->filterBuilder->setField($field);
            $this->filterBuilder->setValue($condition);
            $this->searchCriteriaBuilder->addFilter($this->filterBuilder->create());
        } else {
            if (!empty($condition['from'])) {
                $this->filterBuilder->setField("{$field}.from");
                $this->filterBuilder->setValue($condition['from']);
                $this->searchCriteriaBuilder->addFilter($this->filterBuilder->create());
            }
            if (!empty($condition['to'])) {
                $this->filterBuilder->setField("{$field}.to");
                $this->filterBuilder->setValue($condition['to']);
                $this->searchCriteriaBuilder->addFilter($this->filterBuilder->create());
            }
        }

        return $this;
    }

    /**
     * @param $query
     * @return $this
     */
    public function addSearchFilter($query)
    {
        $this->queryText = trim($this->queryText . ' ' . $query);

        return $this;
    }

    /**
     * @throws LocalizedException
     * @throws \Zend_Db_Exception
     */
    protected function _renderFiltersBefore()
    {
        $this->getCollectionClone();
        $this->getSearchCriteriaBuilder();
        $this->getFilterBuilder();
        $this->getSearch();

        if ($this->queryText) {
            $this->filterBuilder->setField('search_term');
            $this->filterBuilder->setValue($this->queryText);
            $this->searchCriteriaBuilder->addFilter($this->filterBuilder->create());
        }

        $priceRangeCalculation = 'auto';
        if ($priceRangeCalculation) {
            $this->filterBuilder->setField('price_dynamic_algorithm');
            $this->filterBuilder->setValue($priceRangeCalculation);
            $this->searchCriteriaBuilder->addFilter($this->filterBuilder->create());
        }

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchCriteria->setRequestName($this->searchRequestName);

        try {
            $this->searchResult = $this->getSearch()->search($searchCriteria);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Sorry, something went wrong. You can find out more in the error log.'));
        }

        $temporaryStorage = $this->temporaryStorageFactory->create();
        $table = $temporaryStorage->storeDocuments($this->searchResult->getItems());

        $this->getSelect()->joinInner(
            [
                'search_result' => $table->getName(),
            ],
            'e.entity_id = search_result.' . TemporaryStorage::FIELD_ENTITY_ID,
            []
        );

        if ($this->order && 'relevance' === $this->order['field']) {
            $this->getSelect()->order('search_result.' . TemporaryStorage::FIELD_SCORE . ' ' . $this->order['dir']);
        }

        parent::_renderFiltersBefore();
    }

    /**
     * @return $this
     */
    protected function _renderFilters()
    {
        $this->_filters = [];

        return parent::_renderFilters();
    }

    /**
     * @param string $attribute
     * @param string $dir
     * @return $this
     */
    public function setOrder($attribute, $dir = Select::SQL_DESC)
    {
        $this->order = ['field' => $attribute, 'dir' => $dir];
        if ($attribute != 'relevance') {
            parent::setOrder($attribute, $dir);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setGeneralDefaultQuery()
    {
        return $this;
    }

    /**
     * @param $field
     * @return array
     * @throws StateException
     */
    public function getFacetedData($field)
    {
        $this->_renderFilters();
        $result = [];

        $aggregations = $this->searchResult->getAggregations();

        // This behavior is for case with empty object when we got EmptyRequestDataException
        if (null !== $aggregations) {
            $bucket = $aggregations->getBucket($field . RequestGenerator::BUCKET_SUFFIX);
            if ($bucket) {
                foreach ($bucket->getValues() as $value) {
                    $metrics = $value->getMetrics();
                    $result[$metrics['value']] = $metrics;
                }
            } else {
                throw new StateException(__('Bucket does not exist'));
            }
        }

        return $result;
    }

    /**
     * @param \Magento\Catalog\Model\Category $category
     * @return $this
     */
    public function addCategoryFilter(\Magento\Catalog\Model\Category $category)
    {
        $this->addFieldToFilter('category_ids', $category->getId());

        return parent::addCategoryFilter($category);
    }

    /**
     * @param array $visibility
     * @return $this
     */
    public function setVisibility($visibility)
    {
        $this->addFieldToFilter('visibility', $visibility);

        return parent::setVisibility($visibility);
    }
}
