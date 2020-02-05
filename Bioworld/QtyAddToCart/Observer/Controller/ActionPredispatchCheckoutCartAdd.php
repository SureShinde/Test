<?php


namespace Bioworld\QtyAddToCart\Observer\Controller;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\ProductFactory;

class ActionPredispatchCheckoutCartAdd implements \Magento\Framework\Event\ObserverInterface
{
    const XML_PATH_FOR_EXCEPTIONAL_CATEGORY_ID = 'tychonsbulkpurchase/general/category_id';
    const XML_PATH_FOR_COMINGSOON_CATEGORY_ID = 'tychonsbulkpurchase/general/comingsoon_id';
    protected $redirect;
    protected $messageManager;
    protected $scopeConfig;
    protected $productFactory;

    public function __construct(
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig,
        ProductFactory $productFactory
    ) {
        $this->redirect = $redirect;
        $this->messageManager = $messageManager;
        $this->scopeConfig=$scopeConfig;
        $this->productFactory=$productFactory;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $excCategoryIds=$this->scopeConfig->getValue(self::XML_PATH_FOR_EXCEPTIONAL_CATEGORY_ID, $storeScope);
        $comingSoonCategoryId=$this->scopeConfig->getValue(self::XML_PATH_FOR_COMINGSOON_CATEGORY_ID, $storeScope);

        $excCatID=explode(',',$excCategoryIds);
        
        $productId = $observer->getRequest()->getParam('product');
        $productData = $this->productFactory->create()->load($productId);
        $stockItem = $productData->getExtensionAttributes()->getStockItem();
        $stockQty = $stockItem->getQty();
        $qty = $observer->getRequest()->getParam('qty');
        $cats = $productData->getCategoryIds();
        $commonCatID = array_intersect($excCatID, $cats);
        $qtyMin = 3;
        if($stockQty > 0 && $stockQty < 3){
            $qtyMin  =  1;        
       }
       if(($productData->getAttributeText('moq_applicable') == 'Yes') && (!$commonCatID) && ($qty < $qtyMin)){
                    $observer->getRequest()->setParam('product', false);
                    $this->messageManager->addError(__('Minimum '.$qtyMin.' quantity required to add to cart.'));
        }
        if($stockQty <=0 && in_array($comingSoonCategoryId, $cats) && $qty < $qtyMin)
        {
            $observer->getRequest()->setParam('product', false);
            $this->messageManager->addError(__('Minimum 3 quantity required to add to cart.'));
        }
    }
}
