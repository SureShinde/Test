<?php
/**
 * Module 		: Bulkpurchase
 * Author 		: Tychons Magento Team
 * Date 		: July 2019
 * Description 	: Bulk order functionality from product category page.
*/

namespace Bioworld\Bulkpurchase\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    const XML_PATH_FOR_EXCEPTIONAL_CATEGORY_ID = 'tychonsbulkpurchase/general/category_id';
	protected $_pageFactory;
	protected $formKey;
    protected $cart;
    protected $product;
    protected $helperData;
    protected $productFactory;
    protected $storeManager;
    protected $logger;
    protected $scopeConfig;

	public function __construct(
		Context $context,
		FormKey $formKey,
		Cart $cart,
		Product $product,
		PageFactory $pageFactory,
		ProductFactory $productFactory,
		StoreManagerInterface $storeManager,
		ScopeConfigInterface $scopeConfig,
		LoggerInterface $logger
	)
	{
		$this->_pageFactory = $pageFactory;
		$this->formKey = $formKey;
	    $this->cart = $cart;
	    $this->product = $product; 
	    $this->productFactory=$productFactory;
	    $this->storeManager=$storeManager;
	    $this->scopeConfig=$scopeConfig;
	    $this->logger=$logger;
		return parent::__construct($context);
	}

	/*
	* Add Products to Cart
	*/

	public function execute()
	{
	    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	$excCategoryIds=$this->scopeConfig->getValue(self::XML_PATH_FOR_EXCEPTIONAL_CATEGORY_ID, $storeScope);
      	$excCatID=explode(',',$excCategoryIds);

		if (!$this->getRequest()->isAjax()) {
            die('Invalid Request');
        }

		$params = $this->getRequest()->getParams();


		$product_id 	= $this->getRequest()->getParam('product');
        $cat_id 		= $this->getRequest()->getParam('cat_id');
        $qty 			= $this->getRequest()->getParam('qty');
        $product_array 	= $this->getRequest()->getParam($product_id);
        $product_child 	= $this->getRequest()->getParam('product_child');
        $moqRule     	= $this->getRequest()->getParam('moqRule');

        $qtyMin = 0;
        $qty1 = '';
		$flag1 = '';
		$flag = 0;
		$msg['resp']='';

		$e=0;
        foreach($product_child as $pid => $product_array)
		{
			foreach($product_array as $stock => $qty_array)
			{
				foreach($qty_array as $min_qty => $quantity)
				{
					if($quantity>0 && $quantity!='')
					{
						if($stock <= 2)
						{
							$flag = 1;
                			$qtyMin = $qtyMin + $quantity;
						}
						else {
			                $flag1 = 1;
			                $qtyMin = $qtyMin + $quantity;
			            }
					}
					else{
						$e++;
					}
				}				
			}
		}

		if(count($product_child)==$e)
		{
			$msg['resp'] = 'Please enter qty before submit';
		}

			foreach($product_child as $pid => $product_array)
			{
			foreach($product_array as $stock => $qty_array)
			{
				foreach($qty_array as $min_qty => $quantity)
				{
						if($quantity>0 && $quantity!='')
						{

							$currPrd=$this->productFactory->create()->load($pid);
							$cats = $currPrd->getCategoryIds();
							$commonCatID = array_intersect($excCatID, $cats);

							if(!$commonCatID){
									if ($qtyMin < 3 ) {
							            $msgr = 'Minimum 3 quantity required.';
							            $msg['resp'] = $msgr;
						        	}
				        	else{
				        		try {

								$params = array(
						                    'form_key' => $this->formKey->getFormKey(),
						                    'product' => $pid, 
						                    'qty'   => $quantity,
						                );  

								$storeId = $this->storeManager->getStore()->getId();

		                		$product = $this->product->setStoreId($storeId)->load($pid);

						        $this->cart->addProduct($product, $params);

						        $msg['resp'] = 'Success';

					        } catch (\Exception $e) {
					        	$msg['resp'] = $e->getMessage();
				                $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
				                $this->logger->critical($e);
				            }
				        	}
				        	}
				        	else{
				        		try {
						
								$params = array(
						                    'form_key' => $this->formKey->getFormKey(),
						                    'product' => $pid, 
						                    'qty'   => $quantity,
						                );  

								$storeId = $this->storeManager->getStore()->getId();

		                		$product = $this->product->setStoreId($storeId)->load($pid);

						        $this->cart->addProduct($product, $params);

						        $msg['resp'] = 'Success';

					        } catch (\Exception $e) {
					        	$msg['resp'] = $e->getMessage();
				                $this->messageManager->addException($e, __('We can\'t add this item to your shopping cart right now.'));
				                $this->logger->critical($e);
				            }
				        	} 
							
				}
					
				}

			}
			}

			
			if($msg['resp']=='Success')
			{
				$this->cart->save();
				$this->cart->save()->getQuote()->collectTotals();	
			}
					
		$product_poup = $msg;

        $this->getResponse()->setBody(json_encode($product_poup));
        return ;
	}

}
