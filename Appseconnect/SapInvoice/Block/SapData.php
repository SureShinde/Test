<?php
namespace Appseconnect\SapInvoice\Block;
class SapData extends \Magento\Framework\View\Element\Template
{
    protected $invoice;
    protected $order;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Api\Data\OrderInterface $order,
        \Magento\Sales\Model\Order\Invoice $invoice,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    )
    {
        $this->request = $request;
        $this->order = $order;
        $this->invoice = $invoice;
        parent::__construct($context, $data);
    }

    public function customSapInvoiceData()
    {
        $id = $this->request->getParam('order_id');
        $order = $this->order->load($id);
        foreach ($order->getInvoiceCollection() as $inv) {
            $invIncrementIds = $inv->getIncrementId();
        }
         $invoice = $this->invoice->loadByIncrementId($invIncrementIds);

        return $invoice;
    }
}