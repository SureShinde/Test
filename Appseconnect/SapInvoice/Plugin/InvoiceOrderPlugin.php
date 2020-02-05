<?php
namespace Appseconnect\SapInvoice\Plugin;
use Magento\Sales\Api\Data\InvoiceExtensionFactory;
use Magento\Sales\Api\Data\InvoiceExtensionInterface;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Api\Data\InvoiceSearchResultInterface;
use Magento\Sales\Api\Data\InvoiceCommentCreationInterface;
use Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface;
use Magento\Sales\Api\InvoiceOrderInterface;

use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\Config as OrderConfig;
use Magento\Sales\Model\Order\Invoice\NotifierInterface;
use Magento\Sales\Model\Order\InvoiceDocumentFactory;
use Magento\Sales\Model\Order\InvoiceRepository;
use Magento\Sales\Model\Order\OrderStateResolverInterface;
use Magento\Sales\Model\Order\PaymentAdapterInterface;
use Magento\Sales\Model\Order\Validation\InvoiceOrderInterface as InvoiceOrderValidator;
use Psr\Log\LoggerInterface;


class InvoiceOrderPlugin
{
    const INVOICE_NUMBER = 'invoice_number';
    const CUSTOMER_NUMBER = 'customer_number';
    const YOUR_CONTACT = 'your_contact';
    const PAYMENT_TERM = 'payment_term';
    const COMMENT = 'comment';
    const POSTING_DATE = 'posting_date';
    const ADDITIONAL_CHARGES ='additional_charges';
    const DISCOUNT_CHARGE = 'discount_charge';
    const ENVIRONMENTAL_FEES = 'environmental_fees';
    protected $extensionFactory;
    protected $invoice;

    public function __construct(
        InvoiceExtensionFactory $extensionFactory,
        ResourceConnection $resourceConnection,
        OrderRepositoryInterface $orderRepository,
        InvoiceDocumentFactory $invoiceDocumentFactory,
        PaymentAdapterInterface $paymentAdapter,
        OrderStateResolverInterface $orderStateResolver,
        OrderConfig $config,
        InvoiceRepository $invoiceRepository,
        InvoiceOrderValidator $invoiceOrderValidator,
        NotifierInterface $notifierInterface,
        LoggerInterface $logger,
        \Magento\Sales\Model\Order\Invoice $invoice
        )
    {
        $this->extensionFactory = $extensionFactory;

        $this->resourceConnection = $resourceConnection;
        $this->orderRepository = $orderRepository;
        $this->invoiceDocumentFactory = $invoiceDocumentFactory;
        $this->paymentAdapter = $paymentAdapter;
        $this->orderStateResolver = $orderStateResolver;
        $this->config = $config;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceOrderValidator = $invoiceOrderValidator;
        $this->notifierInterface = $notifierInterface;
        $this->logger = $logger;
        $this->invoive = $invoice;
    }

    public function aroundExecute(
        InvoiceOrderInterface $subject,
        callable $proceed,
        $orderId,
        $capture = false,
        array $items = [],
        $notify = false,
        $appendComment = false,
        \Magento\Sales\Api\Data\InvoiceCommentCreationInterface $comment = null,
        \Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface $arguments = null
    )
    {
        if($arguments) {
            $extensionAttributes = $arguments->getExtensionAttributes();
            $invoiveId = $proceed($orderId, $capture, $items, $notify, $appendComment, $comment, $arguments);
            $invoice = $this->invoiceRepository->get($invoiveId);
            $invoice->setInvoiceNumber($extensionAttributes->getInvoiceNumber());
            $invoice->setCustomerNumber($extensionAttributes->getCustomerNumber());
            $invoice->setYourContact($extensionAttributes->getYourContact());
            $invoice->setPaymentTerm($extensionAttributes->getPaymentTerm());
            $invoice->setComment($extensionAttributes->getComment());

            $invoice->setPostingDate($extensionAttributes->getPostingDate());
            $invoice->setAdditionalCharges($extensionAttributes->getAdditionalCharges());
            $invoice->setDiscountCharge($extensionAttributes->getDiscountCharge());
            $invoice->setEnvironmentalFees($extensionAttributes->getEnvironmentalFees());
            $invoice->save();
        } else {
            $invoiveId = $proceed($orderId, $capture, $items, $notify, $appendComment, $comment, $arguments);
        }

        return $invoiveId;
    }
}
