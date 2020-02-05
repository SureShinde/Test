<?php
namespace Appseconnect\SapInvoice\Observer;
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

class UpdateInvoice implements \Magento\Framework\Event\ObserverInterface
{

    const INVOICE_NUMBER = 'invoice_number';
    const CUSTOMER_NUMBER = 'customer_number';
    const YOUR_CONTACT = 'your_contact';
    const PAYMENT_TERM = 'payment_term';
    const COMMENT = 'comment';
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
        \Magento\Sales\Model\Order\Invoice $invoice,
        \Magento\Framework\App\RequestInterface $request
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
        $this->invoice = $invoice;
        $this->_request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $invoiceData = $this->_request->getPost();
        if ($invoiceData['admin_hidden'] == 'hidden_admin') {
            $invoice = $observer->getEvent()->getInvoice();
            $invoice_id = $invoice->getData('entity_id');
            $invoice = $this->invoiceRepository->get($invoice_id);
            $invoice->setInvoiceNumber($invoiceData['invoice_number']);
            $invoice->setCustomerNumber($invoiceData['customer_number']);
            $invoice->setYourContact($invoiceData['your_contact']);
            $invoice->setPaymentTerm($invoiceData['payment_term']);
            $invoice->setComment($invoiceData['comment']);
            $invoice->setPostingDate($invoiceData['posting_date']);
            $invoice->setAdditionalCharges($invoiceData['additional_charges']);
            $invoice->setDiscountCharge($invoiceData['discount_charge']);
            $invoice->setEnvironmentalFees($invoiceData['environmental_fees']);
            $invoice->save();
        }
    }

}
