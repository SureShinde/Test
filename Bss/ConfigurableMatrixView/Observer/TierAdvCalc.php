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
namespace Bss\ConfigurableMatrixView\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class TierAdvCalc implements ObserverInterface
{

    protected $_productRepository;

    protected $_helperc;

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Helper\Data $helperc
        ) {
        $this->_productRepository = $productRepository;
        $this->_helperc = $helperc;
    }

    public function execute(Observer $observer)
    {
        $_helper = \Magento\Framework\App\ObjectManager::getInstance()->get('\Bss\ConfigurableMatrixView\Helper\Data');

        if ($_helper->isEnabled() && $_helper->calculateTierPrice()) {
            $total_qty  = [];
            $quote = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Checkout\Model\Cart')->getQuote();
            foreach ($quote->getAllVisibleItems() as $item) {
                if ($item->getProductType() == 'configurable') {
                    $product = $this->_productRepository->getById($item->getProductId());
                    if (isset($total_qty[$product->getId()])) {
                        $total_qty[$product->getId()] += (int)$item->getQty();
                    } else {
                        $total_qty[$product->getId()]  = $item->getQty();
                    }
                }
            }
            foreach ($quote->getAllVisibleItems() as $item) {
                if ($item->getProductType() == 'configurable') {
                    $qty = $total_qty[$item->getProductId()];
                    $_productchild_id = $item->getOptionByCode('simple_product')->getProduct()->getId();
                    $_productchild  = $this->_productRepository->getById($_productchild_id);
                    $_productparent = $this->_productRepository->getById($item->getProductId());
                    $tier_pricer = [];
                    $allProducts_child = $_productparent->getTypeInstance()->getUsedProducts($_productparent, null);
                    foreach ($allProducts_child as $v) {
                        if ($v->getTierPrice()) {
                            $tier_pricer[] = $v->getTierPrice();
                        }
                    }
                    $cks_tier_price = true;
                    if (count($allProducts_child) == count($tier_pricer)) {
                        foreach ($tier_pricer as $tier_price) {
                            if ($tier_price != $tier_pricer[0]) {
                                $cks_tier_price = false;
                                break;
                            }
                        }
                    } else {
                        $cks_tier_price = false;
                    }
                    
                    $totalCustomOptionPrice = $this->_getTotalCustomOptionPrice($_productparent, $item);
                    $tierPrice = $_productchild->getTierPrice($qty);
                    if (isset($tierPrice) && $tierPrice > 0 && $tierPrice < $_productchild->getFinalPrice() && $cks_tier_price) {
                        $tierPrice = $this->_helperc->getTaxPrice($_productparent, $tierPrice, true, null, null, null, null, null, false);
                        $item->setCustomPrice(round($tierPrice + $totalCustomOptionPrice, 2));
                        $item->setOriginalCustomPrice(round($tierPrice + $totalCustomOptionPrice, 2));
                        $item->getProduct()->setIsSuperMode(true);
                    }
                }
            }
        }
    }

    protected function _getTotalCustomOptionPrice($product, $item)
    {
        $totalCustomOptionPrice = 0;
        $options = $product->getOptions();
        foreach ($item->getBuyRequest()->getOptions() as $code => $option) {
            $customOptionItem[$code] = $option;
        }
        foreach ($options as $option) {
            if (!isset($customOptionItem[$option->getId()])) {
                continue;
            }
            if ($option->getType() === 'drop_down' || $option->getType() === 'radio') {
                $values = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Catalog\Model\Product\Option\Value')->getValuesCollection($option);
                foreach ($values as $value) {
                    if ($value->getId() == $customOptionItem[$option->getId()]) {
                        if ($value->getPriceType() == "fixed") {
                            $totalCustomOptionPrice += $this->_helperc->getTaxPrice($product, $value->getPrice(), true, null, null, null, null, null, false);
                        }
                    }
                }
            } elseif ($option->getType() === 'checkbox' || $option->getType() === 'multiple') {
                $values = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Catalog\Model\Product\Option\Value')->getValuesCollection($option);
                foreach ($values as $value) {
                    if (in_array($value->getId(), $customOptionItem[$option->getId()])) {
                        if ($value->getPriceType() == "fixed") {
                            $totalCustomOptionPrice += $this->_helperc->getTaxPrice($product, $value->getPrice(), true, null, null, null, null, null, false);
                        }
                    }
                }
            } else {
                if ($option->getPriceType() == "fixed") {
                    $totalCustomOptionPrice += $this->_helperc->getTaxPrice($product, $option->getPrice(), true, null, null, null, null, null, false);
                }
            }
        }
        return $totalCustomOptionPrice;
    }
}