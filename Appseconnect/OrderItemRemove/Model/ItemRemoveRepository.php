<?php
namespace Appseconnect\OrderItemRemove\Model;
use Appseconnect\OrderItemRemove\Api\ItemRemoveRepositoryInterface;
use Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface;
use Appseconnect\OrderItemRemove\Api\Data\ItemsInterface;

class ItemRemoveRepository implements ItemRemoveRepositoryInterface
{

    protected $scopeConfig;

    protected $shipconfig;
    protected $objectManager;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Quote\Api\Data\CartItemInterfaceFactory
     */
    protected $cartItemFactory;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Sales\Model\Order\ItemFactory
     */
    protected $orderItemFactory;

    /**
     * ItemRemoveRepository constructor.
     * @param \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterfaceFactory $itemRemoveFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\Config $shipconfig
     * @param \Magento\SalesRule\Model\RuleRepository $ruleRepository
     */

    public function __construct(
        \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterfaceFactory $itemRemoveFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shipconfig,
        \Magento\SalesRule\Model\RuleRepository $ruleRepository,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Quote\Api\Data\CartItemInterfaceFactory $cartItemFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Sales\Model\Order\ItemFactory $orderItemFactory,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollection,
        \Magento\SalesRule\Model\RulesApplier $rulesApplier
    )
    {
        $this->itemRemoveFactory = $itemRemoveFactory;
        $this->_objectManager = $objectManager;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->shipconfig = $shipconfig;
        $this->scopeConfig = $scopeConfig;
        $this->ruleRepository = $ruleRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->cartItemFactory = $cartItemFactory;
        $this->quoteRepository = $quoteRepository;
        $this->orderItemFactory = $orderItemFactory;
        $this->ruleCollection = $ruleCollection;
        $this->rulesApplier = $rulesApplier;
    }

    /**
     * @param ItemRemoveInterface $data
     * @return ItemRemoveInterface|Exception|\Exception|string|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function update(ItemRemoveInterface $data)
    {
        $orderData = $this->extensibleDataObjectConverter->toNestedArray($data, [], '\Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface');
        $orderId = $orderData['order_id'];
        $newsku = array();
        $item_count = 0;
        $item_qty = 0;
        foreach ($orderData['items'] as $data) {
            $newsku[] = $data['sku'];
            $item_count ++;
            $item_qty += $data['qty_ordered'];
        }
        $oldsku = array();
        $order = $this->orderRepository->get($orderId);
            if ($order->getStatus() == "pending") {
                $items = $order->getAllItems();
                foreach ($items as $item) {
                    $oldsku[] = $item->getSku();
                }
                //----Delete----////
                $skus = array_diff($oldsku, $newsku);
                if (count($skus)) {
                    $this->runItem($skus, $orderId, 1, $orderData['items']);
                }

                /////----update----////
                $skus = array_intersect($oldsku, $newsku);
                if (count($skus)) {
                    $this->runItem($skus, $orderId, 2, $orderData['items']);
                }
                //////////////////////////
                ////----Add----////
                $skus = array_diff($newsku, $oldsku);
                if (count($skus)) {
                    $this->runItem($skus, $orderId, 3, $orderData['items']);
                }

                $this->orderUpdate($orderId,$orderData,$item_count,$item_qty);

                //        //////////////////////////
                $order = $this->_objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);
                if ($order->getShippingMethod() == "freeshipping_freeshipping") {
                    if ($order->getBaseSubTotal() < 1000) {
                        $order->setMethodTitle('Freight charge applied on invoice');
                        $order->setShippingMethod('mpcustomshipping_mpcustomshipping');
                        $order->SetShippingAmount(0);
                        $order->save();
                    }
                }
//                $orderDet = $this->_objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);
//                $items = $orderDet->getItems();
//                $itemsData= array();
//                $data = array();
//                $data['order_details'] = $orderDet->getData();
//                foreach($items as $item){
//                    $itemsData[] = $item->getData();
//                }
//                $data['items'] = $itemsData;
//                $data['billing_address'] = $orderDet->getBillingAddress()->getData();
//                $data['payment'] = $orderDet->getPayment()->getData();
//                return  preg_replace("!([\b\t\n\r\f\"\\'])!", "'",json_encode($data));
                return $this->orderRepository->get($orderId);

            } else {
                return "Can't edit order";
            }

    }

    public function runItem($skus, $orderId,$id, $datas)
    {
        foreach ($skus as $sku) {
            if ($id == 1) {
                $this->deleteItem($orderId, $sku);
            } elseif ($id == 2) {
                foreach ($datas as $data) {
                    if ($data['sku'] == $sku) {
                        $this->updateOrderItem($orderId, $sku, $data);
                    }
                }
            } elseif ($id == 3) {
                foreach ($datas as $data) {
                    if ($data['sku'] == $sku) {
                        $this->addOrderItem($orderId, $sku, $data);
                    }
                }
            }
        }

    }





    public function addOrderItem($orderId,$productSku, $data){
        $product = $this->productRepository->get($productSku);
        $order = $this->orderRepository->get($orderId);
        $quote = $this->quoteRepository->get($order->getQuoteId());
        $price = $product->getPrice();

        try {
            $orderItem = $this->orderItemFactory->create();
            $quoteItem = $this->cartItemFactory->create();
            $quoteItem->setProduct($product);
            $quoteItem->setCustomPrice($data['price']);
            $quoteItem->setOriginalCustomPrice($data['price']);
            $quoteItem->getProduct()->setIsSuperMode(true);
            $quote->addItem($quoteItem);
            $quote->collectTotals()->save();
            /* Add Quote Item End */

            /* Add Order Item Start */

            $orderItem
                ->setStoreId($order->getStoreId())
                ->setQuoteItemId($quoteItem->getId())
                ->setProductId($product->getId())
                ->setProductType($product->getTypeId())
                ->setName($product->getName())
                ->setSku($product->getSku())
                ->setQtyOrdered($data['qty_ordered'])
                ->setPrice($data['price'])
                ->setBasePrice($data['base_price'])
                ->setOriginalPrice($price)
                ->setBaseOriginalPrice($data['base_original_price'])
                ->setPriceInclTax($data['base_price_incl_tax'])
                ->setBasePriceInclTax($data['base_price_incl_tax'])
                ->setRowTotal($data['row_total'])
                ->setBaseRowTotal($price)
                ->setRowTotalInclTax($data['price'] + $data['tax_amount'])
                ->setBaseRowTotalInclTax($data['price'] + $data['tax_amount'])
                ->setWeight(0)
                ->setIsVirtual(0)
                ->setTaxAmount($data['tax_amount'])
                ->setTaxPercent($data['tax_percent']);
            $order->addItem($orderItem);
            $this->orderRepository->save($order);

            /* Update relevant order totals End */
        }
        catch (Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
    }

    public function deleteItem($orderId, $sku){
        $order = $this->orderRepository->get($orderId);
        $items = $order->getAllItems();
        foreach ($items as $item) {
            if ($item->getSku() == $sku) {
                try {
                    $item->delete();
                    $order->save();
                }catch(Exception $e){
                    return $e;
                }
                break;
            }
        }
    }


    public function updateOrderItem($orderId,$sku,$data){

        $order = $this->_objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);
        $items = $order->getAllItems();
        foreach ($items as $item) {
            if ($item->getSku() == $sku) {
                try {
                    $item->setQtyOrdered($data['qty_ordered']);
                    $item->setPrice($data['price']);
                    $item->setBasePrice($data['base_price']);
                    $item->setBaseOriginalPrice($data['base_original_price']);
                    $item->setPriceInclTax($data['base_price_incl_tax']);
                    $item->setBasePriceInclTax($data['base_price_incl_tax']);
                    $item->setRowTotal($data['row_total']);
                    $item->setBaseRowTotal($data['row_total']);
                    $item->setRowTotalInclTax($data['row_total'] + $data['tax_amount']);
                    $item->setBaseRowTotalInclTax($data['row_total'] + $data['tax_amount']);
                    $item->setTaxAmount($data['tax_amount']);
                    $item->setTaxPercent($data['tax_percent'])->save();
                    $item->save();
                    $order->save();

                    //////////////////End Order Lavel update////////////

                }catch (Exception $e){
                    return $e;
                }
                break;
            }
        }
    }

    public function getShippingMethods(){
        $activeCarriers = $this->shipconfig->getActiveCarriers();
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        foreach($activeCarriers as $carrierCode => $carrierModel)
        {
            $options = array();
            if( $carrierMethods = $carrierModel->getAllowedMethods() )
            {
                foreach ($carrierMethods as $methodCode => $method)
                {
                    $code= $carrierCode.'_'.$methodCode;
                    $options[]=array('value'=>$code,'label'=>$method);

                }
                $carrierTitle =$this->scopeConfig->getValue('carriers/'.$carrierCode.'/title');
            }
            $methods[]=array('value'=>$options,'label'=>$carrierTitle);
        }
        return $methods;

    }

    public function orderUpdate($orderId,$data,$item_count,$item_qty){

        $order = $this->_objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);
        $order->setBaseDiscountAmount(0);
        $order->setDiscount(0);
        $order->setBaseGrandTotal($data['base_grand_total']);
        $order->setBaseSubtotal($data['base_subtotal']);
        $order->setGrandTotal($data['grand_total']);
        $order->setSubtotal($data['sub_total']);
        $order->setBaseSubtotalInclTax($data['base_subtotal_incl_tax']);
        $order->setSubtotalInclTax($data['sub_total'] + $data['base_tax_amount']);
        $order->setBaseTaxAmount($data['base_tax_amount']);
        $order->setShippingAmount($data['shipping_amount']);
        $order->setShippingInclTax($data['shipping_incl_tax']);
        $order->setShippingTaxAmount($data['shipping_tax_amount']);
        $order->setBaseShippingAmount($data['base_shipping_amount']);
        $order->setBaseShippingTaxAmount($data['base_shipping_tax_amount']);
        $order->setBaseTaxAmount($data['base_tax_amount']);
        $order->setTaxAmount($data['base_tax_amount']);
        $order->setBaseTotalDue($data['base_total_due']);
        $order->setTotalQtyOrdered($item_qty);
        $order->setTotalItemCount($item_count);
        $order->save();
    }

}

