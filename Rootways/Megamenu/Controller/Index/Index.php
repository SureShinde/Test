<?php
/**
 * Mega Menu Index Controller.
 *
 * @category  Site Search & Navigation
 * @package   Root_Mega_Menu
 * @author    Developer RootwaysInc <developer@rootways.com>
 * @copyright 2017 Rootways Inc. (https://www.rootways.com)
 * @license   Rootways Custom License
 * @link      https://www.rootways.com/shop/media/extension_doc/license_agreement.pdf
*/
namespace Rootways\Megamenu\Controller\Index;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    /**
     * Inherits other blocks
    */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    
    /**
     * Index file execute method
    */
    public function execute()
    {   
        $page_object = $this->pageFactory->create();;
        return $page_object;
    }    
}
