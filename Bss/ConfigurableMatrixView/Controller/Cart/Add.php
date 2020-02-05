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
namespace Bss\ConfigurableMatrixView\Controller\Cart;

class Add extends \Magento\Checkout\Controller\Cart\Add
{
	public function execute()
    {
    
        // if (!$this->_formKeyValidator->validate($this->getRequest())) {
        //     return $this->resultRedirectFactory->create()->setPath('*/*/');
        // }
        
        $params = $this->getRequest()->getParams();

        echo '<pre>';
        print_r($params);
        exit;
        $addedProducts = [];

        $productId = (int)$this->getRequest()->getPost('product');
        $productIds = $this->getRequest()->getPost('super_attribute_'.$productId);
        $product_fail = [];
        $product_success = [];
        $product_fail = [];
        $i = 0;
        $total_qty = 0;
        foreach($productIds as $key => $super_attribute) {
            try {
                $qty = $this->getRequest()->getPost('qty_'.$productId.'_'.$key, 0);
                $total_qty += $qty;

                if ($qty <= 0) {
                    continue;
                }

                $storeId = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore()->getId();
                $product = $this->_objectManager->create('Magento\Catalog\Model\Product')->setStoreId($storeId)->load($productId);

                $paramsr = [];
                $paramsr['product']= $productId;
                $paramsr['qty']= $qty;
                $paramsr["super_attribute"] = [];
                $paramsr["super_attribute"] = $super_attribute;
                if ($this->getRequest()->getPost('super_attribute')) {
                    $paramsr["super_attribute"] = $paramsr["super_attribute"] + $this->getRequest()->getPost('super_attribute');
                }
                if (!isset($params['options'])) {
                    $paramsr['options'] = [];
                } else {
                    $paramsr['options'] = $params['options'];
                }
                $childProduct = $this->_objectManager->create('\Magento\ConfigurableProduct\Model\Product\Type\Configurable')                                   ->getProductByAttributes($paramsr['super_attribute'], $product);
                if (!$product) {
                    return $this->goBack();
                }

                $this->cart->addProduct($product, $paramsr);
                if ($i < 1) {
                   if (!empty($related)) {
                        $this->cart->addProductsByIds(explode(',', $related));
                    }
                }
                
                if (!$this->_checkoutSession->getNoCartRedirect(true)) {
                    if (!$this->cart->getQuote()->getHasError()) {
                        $addedProducts[] = $childProduct;
                    }
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                if ($this->_checkoutSession->getUseNotice(true)) {
                    $product_fail[$childProduct->getId()] = $e->getMessage();
                } else {
                    $messages = array_unique(explode("\n", $e->getMessage()));
                    $product_fail[$childProduct->getId()] = end($messages);
                }
                $cartItem = $this->cart->getQuote()->getItemByProduct($product);
                if ($cartItem) {
                    $this->cart->getQuote()->deleteItem($cartItem);
                }
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
                \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class)->critical($e);
            }
        }

        if ($total_qty <= 0) {
            $this->messageManager->addError("Can't add product to cart !");
            return $this->goBack();
        }
        $i++;
        if ($addedProducts) {
            $products = [];
            foreach ($addedProducts as $product) {
                $products[] = '"' . $product->getName() . '"';
            }

            $this->messageManager->addSuccess(
                __('%1 product(s) have been added to shopping cart: %2.', count($addedProducts), join(', ', $products))
            );

            // save cart and collect totals
            $this->cart->save()->getQuote()->collectTotals();
        }

        $product_poup['errors'] = $product_fail;

        $this->getResponse()->setBody(json_encode($product_poup));
        return ;
    }

    protected function goBack($backUrl = null, $product = null)
    {
        if (!$this->getRequest()->isAjax()) {
            return parent::_goBack($backUrl);
        }

        $result = [];

        if ($backUrl || $backUrl = $this->getBackUrl()) {
            $result['backUrl'] = $backUrl;
        } else {
            if ($product && !$product->getIsSalable()) {
                $result['product'] = [
                    'statusText' => __('Out of stock')
                ];
            }
        }

        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result)
        );
    }
}