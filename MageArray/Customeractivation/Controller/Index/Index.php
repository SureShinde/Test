<?php
namespace MageArray\Customeractivation\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	/**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectmanager;
    /**
     * @var \MageArray\Customeractivation\Helper\Data
     */
    protected $_datahelper;
    /**
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $_inlinetranslation;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportbuilder;

    /**
     * @param Context $context
     */

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\MageArray\Customeractivation\Helper\Data $dataHelper,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Escaper $escaper
	)
	{
		$this->_pageFactory = $pageFactory;
		$this->_objectmanager = $context->getObjectManager();
        $this->_datahelper = $dataHelper;
        $this->_inlinetranslation = $inlineTranslation;
        $this->_escaper = $escaper;
        $this->_transportbuilder = $transportBuilder;
		return parent::__construct($context);
	}

	/**
     * Check the permission to run it
     *
     * @return bool
     */

    public function execute()
    {
        $customerId = $this->getRequest()->getParam('customer_id');

        $custCollection = $this->_objectmanager
            ->create('Magento\Customer\Model\Customer')
            ->load($customerId);
        $customerData = $custCollection
            ->getDataModel();

        $currentStatus = $customerData
            ->getCustomAttribute('is_approved');

        $statusValue = 1;
        $customerData->setCustomAttribute('is_approved',
            $statusValue);
        $custCollection->updateData($customerData);
        try{
        	$custCollection->save();
        } catch(\Exception $e) {
        	$e->getMessage();
        }

        $isSendApprovalEmailToCustomer = $this->_datahelper
            ->isSendApprovalEmailToCustomer();

        if ($statusValue
            && $isSendApprovalEmailToCustomer
        ) {

            $senderDetails = $this->_datahelper
                ->getSenderdetail();

            $this->_inlinetranslation
                ->suspend();
            try {
                $custAprvlEmailTemplate = $this->_datahelper
                    ->getcustAprvlEmailTemplate();
                $fname = $customerData->getFirstname();
                $lname = $customerData->getLastname();
                $customerName = $fname . " " . $lname;
                $data = [
                    'name' => $this->_escaper
                        ->escapeHtml($customerName),
                    'email' => $this->_escaper
                        ->escapeHtml($customerData->getEmail()),
                ];
                $dataObject = new \Magento\Framework\DataObject();
                $dataObject->setData($data);

                $sender = $senderDetails;

                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $transport = $this->_transportbuilder
                    ->setTemplateIdentifier($custAprvlEmailTemplate)
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                    )
                    ->setTemplateVars(['data' => $dataObject])
                    ->setFrom($sender)
                    ->addTo($customerData->getEmail(), $storeScope)
                    ->getTransport();
                $transport->sendMessage();;
                $this->_inlinetranslation->resume();

            } catch (\Exception $e) {
                $this->messageManager
                    ->addSuccess(__($e->getMessage()));
            }
        }

        $this->messageManager->addSuccess(__('Customer account approved successfully'));
        $resultRedirect = $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect
            ->setPath('/');
    }
}