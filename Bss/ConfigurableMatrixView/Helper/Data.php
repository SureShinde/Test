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
namespace Bss\ConfigurableMatrixView\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_helperc;

    protected $_scopeConfig;

    protected $_price;

    protected $_registry;

    protected $_currency;

    protected $_request;

    protected $_customer;

    protected $_childPrices = null;

    public function __construct(
        \Magento\Catalog\Helper\Data $helperc,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Pricing\Helper\Data $price,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Model\Session $customer
        ) {
        $this->_helperc = $helperc;
        $this->_scopeConfig = $scopeConfig;
        $this->_price = $price;
        $this->_currency = $currency;
        $this->_registry = $registry;
        $this->_request = $request;
        $this->_customer = $customer;
    }

    public function getConfigFlag($path)
    {
        return $this->_scopeConfig->isSetFlag($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getConfigValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isEnabled()
    {
        $active =  $this->getConfigFlag('configurablematrixview/general/active');
        $customer_group =  $this->getConfigValue('configurablematrixview/general/customer_group');
        $_array_customer_group = explode(',', $customer_group);
        if ($active && $customer_group != ''
            && (in_array(32000, $_array_customer_group)
            || in_array($this->_customer->getCustomerGroupId(), $_array_customer_group))) {
                return true;
        }
        return false;
    }

    public function getSortOption()
    {
        return $this->getConfigFlag('configurablematrixview/general/sort_option');
    }

    public function canShowUnitPrice()
    {
        return $this->getConfigFlag('configurablematrixview/general/unit_price');
    }

    public function canShowTierPrice()
    {
        return $this->getConfigFlag('configurablematrixview/general/tier_price');
    }

    public function canShowPriceRange()
    {
        return $this->getConfigFlag('configurablematrixview/general/price_range');
    }

    public function canShowTotal()
    {
        return $this->getConfigFlag('configurablematrixview/general/show_total');
    }

    public function canShowStock()
    {
        return $this->getConfigFlag('configurablematrixview/general/show_stock');
    }

    public function canShowButtonQty()
    {
        return $this->getConfigFlag('configurablematrixview/general/qty_increase');
    }

    public function calculateTierPrice()
    {
        return $this->getConfigFlag('configurablematrixview/general/tier_price_calculate');
    }

    public function getDisplayPriceWithCurrency($price)
    {
        return $this->_price->currency($price, true, false);
    }

    public function getCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function getMaxPrice()
    {
        $product = $this->_registry->registry('current_product');
        if (is_null($this->_childPrices)) {
            $childenProduct = $product->getTypeInstance()->getUsedProducts($product);
            $array = [];
            foreach ($childenProduct as $product) {
                $array[] = $product->getFinalPrice();
            }
            $this->_childPrices = $array;
        }
        return $this->_helperc->getTaxPrice($product, max($this->_childPrices), true);
    }

    public function getMinPrice()
    {
        $product = $this->_registry->registry('current_product');
        if (is_null($this->_childPrices)) {
            $childenProduct = $product->getTypeInstance()->getUsedProducts($product);
            $array = [];
            foreach ($childenProduct as $product) {
                $array[] = $product->getFinalPrice();
            }
            $this->_childPrices = $array;
        }
        return $this->_helperc->getTaxPrice($product, min($this->_childPrices), true);
    }

    public function getCurrentUrl()
    {
        return $this->_request->getModuleName().'_'.$this->_request->getControllerName().'_'.$this->_request->getActionName();
    }
}
