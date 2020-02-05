<?php
namespace Bioworld\QtyAddToCart\Controller\Configurable\Cart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Psr\Log\LoggerInterface;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;

class Add extends \Bss\ConfigurableMatrixView\Controller\Cart\Add
{
    protected $product;
    protected $configurable;
    protected $logger;
    protected $helper;
    protected $productRepository;
    const XML_PATH_FOR_EXCEPTIONAL_CATEGORY_ID = 'tychonsbulkpurchase/general/category_id';
    const XML_PATH_FOR_COMINGSOON_CATEGORY_ID = 'tychonsbulkpurchase/general/comingsoon_id';

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        ScopeConfigInterface $scopeConfig,
        Session $checkoutSession,
        StoreManagerInterface $storeManager,
        Validator $formKeyValidator,
        CustomerCart $cart,
        ProductRepositoryInterface $productRepository,
        Product $product,
        Configurable $configurable,
        LoggerInterface $logger,
        Data $helper
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart,
            $productRepository
        );
    }

    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $excCategoryIds=$this->_scopeConfig->getValue(self::XML_PATH_FOR_EXCEPTIONAL_CATEGORY_ID, $storeScope);
        $comingSoonCategoryId=$this->_scopeConfig->getValue(self::XML_PATH_FOR_COMINGSOON_CATEGORY_ID, $storeScope);
        $excCatID=explode(',',$excCategoryIds);

        $params = $this->getRequest()->getParams();

        $addedProducts = [];

        $productId = (int)$this->getRequest()->getPost('product');
        $productIds = $this->getRequest()->getPost('super_attribute_'.$productId);
        $product_fail = [];
        $product_success = [];
        $product_fail = [];
        $i = 0;
        $total_qty = 0;

        $Minqty = 0;
                // $qty1 = '';
                $flag1 = '';
                $flag = 0;

        foreach($productIds as $key => $super_attribute) {
            try {
                $qty = $this->getRequest()->getPost('qty_'.$productId.'_'.$key, 0);
                $total_qty += $qty;

                if ($qty <= 0) {
                    continue;
                }

                $storeId = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore()->getId();
                $product = $this->_objectManager->create('Magento\Catalog\Model\Product')->setStoreId($storeId)->load($productId);
                $cats = $product->getCategoryIds();
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

                $productStockObj = $this->_objectManager->get('Magento\CatalogInventory\Api\StockRegistryInterface')->getStockItem($childProduct->getId());
                $stkQty=$productStockObj->getData('qty');
                if($stkQty <=0 && in_array($comingSoonCategoryId, $cats))
                        {
                        $flag1 = 1;
                        $Minqty = $Minqty + $qty;
                        }
                if($qty>0 && $qty!='')
                {
                    if($stkQty <= 2)
                    {
                        $flag = 1;
                        $Minqty = $Minqty + $qty;
                    }
                    else {
                        $flag1 = 1;
                        $Minqty = $Minqty + $qty;
                    }
                }


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
            }
             catch (\Exception $e) {
                $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
                \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class)->critical($e);
            }
        }

        if ($total_qty <= 0) {
            $this->messageManager->addError("Please enter quantity greater than zero");
            return $this->goBack();
        }
        $i++;
        if ($addedProducts) {

            //validating quantity for exceptional categories starts here

            $products = [];
            $commonCatID = array_intersect($excCatID, $cats);
            if(!$commonCatID)
                {
                    if ($Minqty < 3 && $flag1 == 1 && $flag == '') {
                    $this->messageManager->addError(__('Minimum 3 quantity required to add to cart.'));
                    } else if ($Minqty < 3 && $flag1 == 1 && $flag == 1) {
                    $this->messageManager->addError(__('Minimum 3 quantity required to add to cart.'));
                    }
                    else{
                        foreach ($addedProducts as $product) {
                        $products[] = '"' . $product->getName() . '"';
                        }

                        $this->messageManager->addSuccess(
                        __('%1 product(s) have been added to shopping cart: %2.', count($addedProducts), join(', ', $products))
                        );
                        // save cart and collect totals
                        $this->cart->save()->getQuote()->collectTotals();
                    }
                }
            else{
                foreach ($addedProducts as $product) {
                    $products[] = '"' . $product->getName() . '"';
                    }
                $this->messageManager->addSuccess(
                __('%1 product(s) have been added to shopping cart: %2.', count($addedProducts), join(', ', $products))
                );
                // save cart and collect totals
                $this->cart->save()->getQuote()->collectTotals();
            }    


                //validating quantity for exceptional categories ends here 
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
