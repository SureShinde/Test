<?php
namespace Appseconnect\SapInvoice\Model\Pdf;

class Invoice extends \Magento\Sales\Model\Order\Pdf\Invoice
{
    public function getPdf($invoices = []){
        $this->_beforeGetPdf();
        $this->_initRenderer('invoice');
        $pdf = new \Zend_Pdf();
        $this->_setPdf($pdf);
        $style = new \Zend_Pdf_Style();
        $this->_setFontBold($style, 10);
        foreach ($invoices as $invoice)
        {
            if ($invoice->getStoreId())
            {
                $this->_localeResolver->emulate($invoice->getStoreId());
                $this->_storeManager->setCurrentStore($invoice->getStoreId());
            }
            $page = $this->newPage();
            $order = $invoice->getOrder();
            $this->insertLogo($page, $invoice->getStore());
            $this->insertAddress($page, $invoice->getStore());
            $this->insertOrder(
                $page,
                $order,
                $this->_scopeConfig->isSetFlag(
                    self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $order->getStoreId()
                )
            );
            $this->insertDocumentNumber($page, __('Invoice # ') . $invoice->getIncrementId());
            $this->_drawHeader($page);
            foreach ($invoice->getAllItems() as $item)
            {
                if ($item->getOrderItem()->getParentItem())
                {
                    continue;
                }
                $this->_drawItem($item, $page, $order);
                $page = end($pdf->pages);
            }
            $this->insertTotals($page, $invoice);
            if ($invoice->getStoreId())
            {
                $this->_localeResolver->revert();
            }
        }

        if ($invoice->getData('invoice_number') != null) {
            $invoiceNumber = $invoice->getData('invoice_number');
        } else {
            $invoiceNumber = "xxx";
        }
        if ($invoice->getData('customer_number') != null) {
            $customerNumber = $invoice->getData('customer_number');
        } else {
            $customerNumber = "xxx";
        }
        if ($invoice->getData('your_contact') != null) {
            $yourContact = $invoice->getData('your_contact');
        } else {
            $yourContact = "xxx";
        }
        if ($invoice->getData('payment_term') != null) {
            $paymentTerm = $invoice->getData('payment_term');
        } else {
            $paymentTerm = "xxx";
        }
        if ($invoice->getData('comment') != null) {
            $comment = $invoice->getData('comment');
        } else {
            $comment = "xxx";
        }


        if ($invoice->getData('posting_date') != null) {
            $postingDate = $invoice->getData('posting_date');
        } else {
            $postingDate = "xxx";
        }
        if ($invoice->getData('additional_charges') != null) {
            $additionalCharges = $invoice->getData('additional_charges');
        } else {
            $additionalCharges = "xxx";
        }
        if ($invoice->getData('discount_charge') != null) {
            $discountCharge = $invoice->getData('discount_charge');
        } else {
            $discountCharge = "xxx";
        }
        if ($invoice->getData('environmental_fees') != null) {
            $environmentalFees = $invoice->getData('environmental_fees');
        } else {
            $environmentalFees = "xxx";
        }

        // Add Company Name to Invoice PDF
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.0));
        $docHeader = $this->getDocHeaderCoordinates();
        $page->drawText('Invoice Number: '.$invoiceNumber, 150, $docHeader[1]-15, 'UTF-8');
        $page->drawText('Customer Number: '.$customerNumber, 150, $docHeader[1]-30, 'UTF-8');
        $page->drawText('Your Contact: '.$yourContact, 150, $docHeader[1]-45, 'UTF-8');
        $page->drawText('Payment Term: '.$paymentTerm, 300, $docHeader[1]-15, 'UTF-8');
        $page->drawText('Comment: '.$comment, 300, $docHeader[1]-30, 'UTF-8');
        $page->drawText('Posting Date: '.$postingDate, 300, $docHeader[1]-45, 'UTF-8');
        $page->drawText('Additional Charges: '.$additionalCharges, 450, $docHeader[1]-15, 'UTF-8');
        $page->drawText('Discount Charge: '.$discountCharge, 450, $docHeader[1]-30, 'UTF-8');
        $page->drawText('Environmental Fees: '.$environmentalFees, 450, $docHeader[1]-45, 'UTF-8');
        $this->_afterGetPdf();
        return $pdf;
    }
}