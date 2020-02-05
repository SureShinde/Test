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
namespace Bss\LayerNavigation\Model\ResourceModel;

use Magento\CatalogSearch\Model\Layer\Filter\Attribute as CoreAttribute;
use Bss\LayerNavigation\Helper\Data as BssHelper;

class Attribute extends CoreAttribute
{
    /**
     * @var BssHelper
     */
    protected $moduleHelper;

    /**
     * @var bool
     */
    protected $isFilter = true;

    /**
     * @var \Magento\Framework\Filter\StripTags
     */
    private $tagFilter;

    /**
     * @var \Bss\LayerNavigation\Model\Layer\Filter
     */
    protected $moduleFilter;

    /**
     * @var \Bss\LayerNavigation\Model\Layer\Filter
     */
    protected $filterModel;

    /**
     * @var object
     */
    protected $productAttributeCollection;

    /**
     * Attribute constructor.
     * @param \Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Layer $layer
     * @param \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder
     * @param \Magento\Framework\Filter\StripTags $tagFilter
     * @param \Bss\LayerNavigation\Model\Layer\Filter $moduleFilter
     * @param BssHelper $moduleHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Layer $layer,
        \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder,
        \Magento\Framework\Filter\StripTags $tagFilter,
        \Bss\LayerNavigation\Model\Layer\Filter $moduleFilter,
        BssHelper $moduleHelper,
        array $data = []
    ) {
        parent::__construct(
            $filterItemFactory,
            $storeManager,
            $layer,
            $itemDataBuilder,
            $tagFilter,
            $data
        );
        $this->moduleFilter = $moduleFilter;
        $this->tagFilter = $tagFilter;
        $this->moduleHelper = $moduleHelper;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {

        if (!$this->moduleHelper->isEnabled()) {
            return parent::apply($request);
        }

        $attributeValue = $request->getParam($this->_requestVar);
        if (empty($attributeValue)) {
            $this->isFilter = false;
            return $this;
        }

        $productCollection = $this->getLayer()
            ->getProductCollection();

        $this->productAttributeCollection = $productCollection->getCollectionClone();

        $attributeValue = explode('_', $attributeValue);

        $attribute = $this->getAttributeModel();

        if (count($attributeValue) > 1) {
            $productCollection->addFieldToFilter($attribute->getAttributeCode(), ["in" => $attributeValue]);
        } else {
            $productCollection->addFieldToFilter($attribute->getAttributeCode(), $attributeValue[0]);
        }

        $this->moduleFilter->setAttributeArray($attribute->getAttributeCode(), $request->getParam($this->_requestVar));

        $state = $this->getLayer()->getState();
        foreach ($attributeValue as $value) {
            $label = $this->getOptionText($value);
            $state->addFilter($this->_createItem($label, $value));
        }

        return $this;
    }


    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getItemsData()
    {
        if (!$this->moduleHelper->isEnabled()) {
            return parent::_getItemsData();
        }

        $attribute = $this->getAttributeModel();
        $productCollection = $this->getProductCollection($attribute);
        $optionsFacetedData = $productCollection->getFacetedData($attribute->getAttributeCode());

        if (count($optionsFacetedData) === 0
            && $this->getAttributeIsFilterable($attribute) !== static::ATTRIBUTE_OPTIONS_ONLY_WITH_RESULTS
        ) {
            return $this->itemDataBuilder->build();
        }



        $productSize = $productCollection->getSize();

        $options = $attribute->getFrontend()
            ->getSelectOptions();

        $handleOption = $this->handleOption($options, $optionsFacetedData, $productSize, $attribute);

        if ($handleOption['check_count']) {
            foreach ($handleOption['data'] as $item) {
                $this->itemDataBuilder->addItemData($item['label'], $item['value'], $item['count']);
            }
        }

        return $this->itemDataBuilder->build();
    }

    protected function getProductCollection($attribute)
    {
        if ($this->productAttributeCollection) {
            $productCollection = $this->productAttributeCollection;
            if ($this->moduleFilter->getAttributeArray()) {
                foreach ($this->moduleFilter->getAttributeArray() as $key => $value) {
                    if ($attribute->getAttributeCode() !== $key) {
                        $attributeValue = explode('_', $value);
                        if (isset($attributeValue[1])) {
                            $productCollection->addFieldToFilter(
                                $attribute->getAttributeCode(),
                                ["in" => $attributeValue]
                            );
                        } else {
                            $productCollection->addFieldToFilter($key, $attributeValue[0]);
                        }
                    }
                }
            }
        } else {
            $productCollection = $this->getLayer()->getProductCollection();
        }
        return $productCollection;
    }

    protected function handleOption($options, $optionsFacetedData, $productSize, $attribute)
    {
        $dataResult['check_count'] = false;
        $dataResult['data'] = [];
        $itemData   = [];
        $checkCount = false;
        foreach ($options as $option) {
            if (empty($option['value'])) {
                continue;
            }

            $value = $option['value'];

            $count = isset($optionsFacetedData[$value]['count'])
                ? (int)$optionsFacetedData[$value]['count']
                : 0;

            if ($this->getAttributeIsFilterable($attribute) == static::ATTRIBUTE_OPTIONS_ONLY_WITH_RESULTS
                && (!$this->getFilterModel()->isOptionReducesResults($count, $productSize))
            ) {
                continue;
            }

            if ($count > 0) {
                $checkCount = true;
            }

            $itemData[] = [
                'label' => $this->tagFilter->filter($option['label']),
                'value' => $value,
                'count' => $count
            ];
        }
        $dataResult['check_count'] = $checkCount;
        $dataResult['data'] = $itemData;

        return $dataResult;
    }

    /**
     * @return mixed
     */
    public function getFilterModel()
    {
        if (!$this->filterModel) {
            $this->filterModel = $this->moduleFilter;
        }
        return $this->filterModel;
    }
}
