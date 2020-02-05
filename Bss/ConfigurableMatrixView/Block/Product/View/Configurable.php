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
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * BSS Commerce does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * BSS Commerce does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   BSS
 * @package    Bss_ConfigurableMatrixView
 * @author     Extension Team
 * @copyright  Copyright (c) 2015-2016 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\ConfigurableMatrixView\Block\Product\View;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Product as CatalogProduct;
use Magento\ConfigurableProduct\Helper\Data;
use Magento\ConfigurableProduct\Model\ConfigurableAttributeData;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Store\Model\ScopeInterface;
use Magento\Swatches\Helper\Data as SwatchData;
use Magento\Swatches\Helper\Media;
use Magento\Swatches\Model\Swatch;

class Configurable extends \Magento\Swatches\Block\Product\Renderer\Configurable
{
    protected function getRendererTemplate()
    {
        $helper = \Magento\Framework\App\ObjectManager::getInstance()->create('Bss\ConfigurableMatrixView\Helper\Data');
        if ($helper->isEnabled() && $this->getProduct()->getConfigurableMatrixView()) {
            return 'Bss_ConfigurableMatrixView::product/view/configurable.phtml';
        }

        return $this->isProductHasSwatchAttribute ?
            self::SWATCH_RENDERER_TEMPLATE : self::CONFIGURABLE_RENDERER_TEMPLATE;
    }

    public function getAllowProducts()
    {
        if (!$this->hasAllowProducts()) {
            $products = [];
            $skipSaleableCheck = $this->catalogProduct->getSkipSaleableCheck();
            $allProducts = $this->getProduct()->getTypeInstance()->getUsedProducts($this->getProduct(), null);
            $helper = \Magento\Framework\App\ObjectManager::getInstance()->create('Bss\ConfigurableMatrixView\Helper\Data');

            foreach ($allProducts as $product) {
                if ($product->isSaleable() || $skipSaleableCheck) {
                        $products[] = $product;
                }
            }

            $this->setAllowProducts($products);
        }

        return $this->getData('allow_products');
    }

    public function getAttributeMatrix()
    {
        $product = $this->getProduct();
        $productTypeInstance = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\ConfigurableProduct\Model\Product\Type\Configurable');
        $productAttributeOptions = $productTypeInstance->getConfigurableAttributesAsArray($product);
        $attribute_code = [];

        foreach ($productAttributeOptions as $option) {
            if (in_array($option['attribute_code'], $attribute_code)) {
                continue;
            }

            $attribute = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Eav\Model\Config')->getAttribute('catalog_product', $option['attribute_code']);

            if (!$attribute->getIsMatrixView()) {
                continue;
            }

            $attribute_code[$option['attribute_id']] = $option['attribute_code'];
        }

        return array_slice($attribute_code, -2, 2, true);
    }
    
    public function getChildProductAttribute()
    {
        $currentProduct = $this->getProduct();
        $optionPrice = $this->getOptionPrices();
        $options = $this->helper->getOptions($currentProduct, $this->getAllowProducts());
        $attributesData = $this->configurableAttributeData->getAttributesData($currentProduct, $options);
        $attribute_allow = $this->getAttributeMatrix();
        $assc_product_data = [];

        foreach ($this->getAllowProducts() as $product) {
            $data = $options['index'][$product->getId()];
            $data['product_id'] = $product->getId();
            $assc_product_data[] = $data;
        }

        return $assc_product_data;
    }

    public function getConfigurableMatrixViewData()
    {
        $currentProduct = $this->getProduct();
        $optionPrice = $this->getOptionPrices();
        $options = $this->helper->getOptions($currentProduct, $this->getAllowProducts());
        $attributesData = $this->configurableAttributeData->getAttributesData($currentProduct, $options);
        $attribute_allow = $this->getAttributeMatrix();
        $assc_product_data = [];
        $sort = false;

        foreach ($this->getAllowProducts() as $product) {
            $stockRegistry = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\CatalogInventory\Api\StockRegistryInterface');
            $stockitem = $stockRegistry->getStockItem($product->getId(), $product->getStore()->getWebsiteId());
            $data = $options['index'][$product->getId()];
            $data['product_id'] = $product->getId();
            $data['stock'] = $stockitem->getData();
            $data['price'] = [
                                'old_price' => $product->getPriceInfo()->getPrice('regular_price')->getAmount()->getValue(),
                                'basePrice' => $product->getPriceInfo()->getPrice('final_price')->getAmount()->getBaseAmount(),
                                'finalPrice' => $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue()
                            ];
            foreach ($options['index'][$product->getId()] as $key => $option) {
                if (!$sort) {
                    $sort = $key;
                }

                if (!in_array($attributesData['attributes'][$key]['code'], $attribute_allow)) {
                    continue;
                }

                $search = array_search($option, array_column($attributesData['attributes'][$key]['options'], 'id'));
                $data['attributes'][$key] = $attributesData['attributes'][$key]['options'][$search];
                $data['attributes'][$key]['code'] = $attributesData['attributes'][$key]['code'];
            }

            $data['tier_price'] = $product->getTierPrice();
            $assc_product_data[] = $data;
        }
        return $assc_product_data;
    }

    public function getConfigChildProductIds()
    {
        $product = $this->getProduct();
        if ($product->getTypeId() != \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            return [];
        }

        $storeId = $this->_storeManager->getStore()->getId();

        $productTypeInstance = $product->getTypeInstance();
        $productTypeInstance->setStoreFilter($storeId, $product);
        $usedProducts = $productTypeInstance->getUsedProducts($product);
        $childrenList = [];

        foreach ($usedProducts as $child) {
            $attributes = [];
            $isSaleable = $child->isSaleable();
            if ($isSaleable) {
                foreach ($child->getAttributes() as $attribute) {
                    $attrCode = $attribute->getAttributeCode();
                    $value = $child->getDataUsingMethod($attrCode) ?: $child->getData($attrCode);
                    if (null !== $value && $attrCode != 'entity_id') {
                        $attributes[$attrCode] = $value;
                    }
                }
                $attributes['store_id'] = $child->getStoreId();
                $attributes['id'] = $child->getId();
                $productDataObject = $this->productFactory->create();
                $this->dataObjectHelper->populateWithArray(
                    $productDataObject,
                    $attributes,
                    '\Magento\Catalog\Api\Data\ProductInterface'
                );
                $childrenList[] = $productDataObject;
            }
        }

        $childData = [];
        foreach ($childrenList as $child) {
            $childData[] = $child;
        }

        return $childData;
    }

    public function getJsonConfigNoMatrix()
    {
        $store = $this->getCurrentStore();
        $currentProduct = $this->getProduct();

        $regularPrice = $currentProduct->getPriceInfo()->getPrice('regular_price');
        $finalPrice = $currentProduct->getPriceInfo()->getPrice('final_price');

        $options = $this->helper->getOptions($currentProduct, $this->getAllowProducts());
        $attributesData = $this->configurableAttributeData->getAttributesData($currentProduct, $options);
        $attribute_matrix = $this->getAttributeMatrix();

        foreach ($attribute_matrix as $key => $value) {
            unset($attributesData['attributes'][$key]);
        }

        $config = [
            'attributes' => $attributesData['attributes'],
            'template' => str_replace('%s', '<%- data.price %>', $store->getCurrentCurrency()->getOutputFormat()),
            'optionPrices' => $this->getOptionPrices(),
            'prices' => [
                'oldPrice' => [
                    'amount' => $this->_registerJsPrice($regularPrice->getAmount()->getValue()),
                ],
                'basePrice' => [
                    'amount' => $this->_registerJsPrice(
                        $finalPrice->getAmount()->getBaseAmount()
                    ),
                ],
                'finalPrice' => [
                    'amount' => $this->_registerJsPrice($finalPrice->getAmount()->getValue()),
                ],
            ],
            'productId' => $currentProduct->getId(),
            'chooseText' => __('Choose an Option...'),
            'images' => isset($options['images']) ? $options['images'] : [],
            'index' => isset($options['index']) ? $options['index'] : []
        ];

        if ($currentProduct->hasPreconfiguredValues() && !empty($attributesData['defaultValues'])) {
            $config['defaultValues'] = $attributesData['defaultValues'];
        }

        $config = array_merge($config, $this->_getAdditionalConfig());

        return $this->jsonEncoder->encode($config);
    }

    public function getJsonConfigM()
    {
        $store = $this->getCurrentStore();
        $currentProduct = $this->getProduct();

        $regularPrice = $currentProduct->getPriceInfo()->getPrice('regular_price');
        $finalPrice = $currentProduct->getPriceInfo()->getPrice('final_price');

        $options = $this->helper->getOptions($currentProduct, $this->getAllowProducts());
        $attributesData = $this->configurableAttributeData->getAttributesData($currentProduct, $options);

        $config = [
            'attributes' => $attributesData['attributes'],
            'template' => str_replace('%s', '<%- data.price %>', $store->getCurrentCurrency()->getOutputFormat()),
            'optionPrices' => $this->getOptionPrices(),
            'prices' => [
                'oldPrice' => [
                    'amount' => $this->_registerJsPrice($regularPrice->getAmount()->getValue()),
                ],
                'basePrice' => [
                    'amount' => $this->_registerJsPrice(
                        $finalPrice->getAmount()->getBaseAmount()
                    ),
                ],
                'finalPrice' => [
                    'amount' => $this->_registerJsPrice($finalPrice->getAmount()->getValue()),
                ],
            ],
            'productId' => $currentProduct->getId(),
        ];

        if ($currentProduct->hasPreconfiguredValues() && !empty($attributesData['defaultValues'])) {
            $config['defaultValues'] = $attributesData['defaultValues'];
        }

        $config = array_merge($config, $this->_getAdditionalConfig());

        return $this->jsonEncoder->encode($config);
    }

    public function getJsonSwatchNoMatrix()
    {
        $attribute_matrix = $this->getAttributeMatrix();
        $attributesData = $this->getSwatchAttributesData();
        $allOptionIds = $this->getConfigurableOptionsIds($attributesData);
        $swatchesData = $this->swatchHelper->getSwatchesByOptionsId($allOptionIds);

        $config = [];
        foreach ($attributesData as $attributeId => $attributeDataArray) {
            if (isset($attributeDataArray['options'])) {
                if (isset($attribute_matrix[$attributeId])) {
                    continue;
                }
                $config[$attributeId] = $this->addSwatchDataForAttribute(
                    $attributeDataArray['options'],
                    $swatchesData,
                    $attributeDataArray
                );
            }
        }

        return $this->jsonEncoder->encode($config);
    }

    public function getRateTax()
    {
        $currentProduct = $this->getProduct();
        $store = $this->_storeManager->getStore();
        $taxCalculation = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Tax\Model\Calculation');
        $request = $taxCalculation->getRateRequest(null, null, null, $store);
        $taxClassId = $currentProduct->getTaxClassId();
        $percent = $taxCalculation->getRate($request->setProductClassId($taxClassId));
        return $percent;
    }
}
