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
namespace Bss\LayerNavigation\Model\Search;

use Magento\Framework\Api\ObjectFactory;
use Magento\Framework\Api\Search\SearchCriteriaBuilder as SourceSearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;

class SearchCriteriaBuilder extends SourceSearchCriteriaBuilder
{
    /**
     * SearchCriteriaBuilder constructor.
     * @param ObjectFactory $objectFactory
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        ObjectFactory $objectFactory,
        FilterGroupBuilder $filterGroupBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($objectFactory, $filterGroupBuilder, $sortOrderBuilder);
    }

    /**
     * @param $attributeCode
     * @return $this
     */
    public function removeFilter($attributeCode)
    {
        $this->filterGroupBuilder->removeFilter($attributeCode);

        return $this;
    }

    /**
     * @return SearchCriteriaBuilder
     */
    public function cloneObject()
    {
        $cloneObject = clone $this;
        $cloneObject->setFilterGroupBuilder($this->filterGroupBuilder->cloneObject());

        return $cloneObject;
    }

    /**
     * @param $filterGroupBuilder
     */
    public function setFilterGroupBuilder($filterGroupBuilder)
    {
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * @return string
     */
    protected function _getDataObjectType()
    {
        return 'Magento\Framework\Api\Search\SearchCriteria';
    }
}
