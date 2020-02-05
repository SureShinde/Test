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

class UpdateItemOptions extends \Magento\Checkout\Controller\Cart\UpdateItemOptions
{
    public function execute()
    {
        $product_id = (int)$this->getRequest()->getParam('product');
        $params = $this->getRequest()->getParams();
        $quoteArray = [];
        $cart = $this->_objectManager->create('Magento\Checkout\Model\Cart')->getQuote()->getAllVisibleItems();
        foreach ($cart as $item) {
            if ($item->getProductId() == $product_id && $item->getProductType() == 'configurable') {
                $item_id = $item->getOptionByCode('simple_product')->getProduct()->getId();
                $quoteArray[$item_id] = $item->getId();
            }
        };
        $addedProducts = [];

        $productId = (int)$this->getRequest()->getPost('product');
        $productIds = $this->getRequest()->getPost('super_attribute_'.$productId);
        $product_fail = [];
        $product_success = [];
        $product_fail = [];
        $i = 0;
        try {
            foreach($productIds as $key => $super_attribute) {
                $qty = $this->getRequest()->getPost('qty_'.$productId.'_'.$key, 0);
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
                if (!isset($params['options'])) {
                    $paramsr['options'] = [];
                } else {
                    $paramsr['options'] = $params['options'];
                }
                if ($this->getRequest()->getPost('super_attribute')) {
                    $paramsr["super_attribute"] = $paramsr["super_attribute"] + $this->getRequest()->getPost('super_attribute');
                }

                $childProduct = $this->_objectManager->create('\Magento\ConfigurableProduct\Model\Product\Type\Configurable')->getProductByAttributes($paramsr['super_attribute'], $product);
                $id = '';
                if (isset($quoteArray[$childProduct->getId()])) {
                    $id = $quoteArray[$childProduct->getId()];
                }

                $quoteItem = $this->cart->getQuote()->getItemById($id);
                if (!$quoteItem) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('We can\'t find the quote item.'));
                }

                $item = $this->cart->updateItem($id, new \Magento\Framework\DataObject($paramsr));
                if (is_string($item)) {
                    throw new \Magento\Framework\Exception\LocalizedException(__($item));
                }
                if ($item->getHasError()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__($item->getMessage()));
                }

                $related = $this->getRequest()->getParam('related_product');
                if (!empty($related)) {
                    $this->cart->addProductsByIds(explode(',', $related));
                }
            }
                $this->cart->save();

                $this->_eventManager->dispatch(
                    'checkout_cart_update_item_complete',
                    ['item' => $item, 'request' => $this->getRequest(), 'response' => $this->getResponse()]
                );

                if (!$this->_checkoutSession->getNoCartRedirect(true)) {
                    if (!$this->cart->getQuote()->getHasError()) {
                        $message = __(
                            '%1 was updated in your shopping cart.',
                            $this->_objectManager->get('Magento\Framework\Escaper')
                                ->escapeHtml($item->getProduct()->getName())
                        );
                        $this->messageManager->addSuccess($message);
                    }
                    return $this->_goBack($this->_url->getUrl('checkout/cart'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                if ($this->_checkoutSession->getUseNotice(true)) {
                    $this->messageManager->addNotice($e->getMessage());
                } else {
                    $messages = array_unique(explode("\n", $e->getMessage()));
                    foreach ($messages as $message) {
                        $this->messageManager->addError($message);
                    }
                }

                $url = $this->_checkoutSession->getRedirectUrl(true);
                if ($url) {
                    return $this->resultRedirectFactory->create()->setUrl($url);
                } else {
                    $cartUrl = $this->_objectManager->get('Magento\Checkout\Helper\Cart')->getCartUrl();
                    return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRedirectUrl($cartUrl));
                }
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('We can\'t update the item right now.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                return $this->_goBack();
            }
        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}