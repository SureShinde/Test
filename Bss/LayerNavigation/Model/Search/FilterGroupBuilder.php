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

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\ObjectFactory;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\Search\FilterGroupBuilder as SourceFilterGroupBuilder;
use Magento\Framework\App\RequestInterface;

class FilterGroupBuilder extends SourceFilterGroupBuilder
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * FilterGroupBuilder constructor.
     * @param ObjectFactory $objectFactory
     * @param FilterBuilder $filterBuilder
     * @param RequestInterface $request
     */
    public function __construct(
        ObjectFactory $objectFactory,
        FilterBuilder $filterBuilder,
        RequestInterface $request
    ) {
        parent::__construct($objectFactory, $filterBuilder);

        $this->request = $request;
    }

    /**
     * @return FilterGroupBuilder
     */
    public function cloneObject()
    {
        $cloneObject = clone $this;
        $cloneObject->setFilterBuilder(clone $this->_filterBuilder);

        return $cloneObject;
    }

    /**
     * @param $filterBuilder
     */
    public function setFilterBuilder($filterBuilder)
    {
        $this->_filterBuilder = $filterBuilder;
    }

    /**
     * @param $attributeCode
     * @return $this
     */
    public function removeFilter($attributeCode)
    {
        if (isset($this->data[FilterGroup::FILTERS])) {
            foreach ($this->data[FilterGroup::FILTERS] as $key => $filter) {
                if ($filter->getField() == $attributeCode) {
                    if (($attributeCode == 'category_ids') && ($filter->getValue() == $this->request->getParam('id'))) {
                        continue;
                    }
                    unset($this->data[FilterGroup::FILTERS][$key]);
                }
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function _getDataObjectType()
    {
        return 'Magento\Framework\Api\Search\FilterGroup';
    }
}
