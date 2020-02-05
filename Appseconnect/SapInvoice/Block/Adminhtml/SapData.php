<?php
namespace Appseconnect\SapInvoice\Block\Adminhtml;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
class SapData extends Template
{
        public function __construct(
                Context $context,
                \Magento\Sales\Model\Order\Invoice $invoice,
                \Magento\Framework\App\Request\Http $request,
                array $data = [] 
        )
        {
                $this->request = $request;
                $this->invoice = $invoice;
                        parent::__construct($context,$data);
        }
        public function customSapInvoiceData()
        {
                $id = $this->request->getParam('invoice_id');
                $invoice = $this->invoice->load($id);
                return $invoice;
        }
}