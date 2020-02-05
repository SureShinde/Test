<?php
/**
 * Helper file to get data.
 *
 * @category  Site Search & Navigation
 * @package   Root_Mega_Menu
 * @author    Developer RootwaysInc <developer@rootways.com>
 * @copyright 2017 Rootways Inc. (https://www.rootways.com)
 * @license   Rootways Custom License
 * @link      https://www.rootways.com/shop/media/extension_doc/license_agreement.pdf
*/
namespace Rootways\Megamenu\Helper;
use Magento\Framework\View\Result\PageFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_objectManager;
    protected $_categoryHelper;
    protected $_categoryFactory;
    protected $_categoryFlatConfig;
    protected $_filterProvider;
    protected $resultPageFactory;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        PageFactory $resultPageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_objectManager= $objectManager;
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryFlatConfig = $categoryFlatState;
        $this->_categoryHelper = $categoryHelper;
        $this->resultPageFactory = $resultPageFactory;
        $this->_filterProvider = $filterProvider;
        
        parent::__construct($context);
    }
    
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCssDir()
    {
        return BP.'/pub/media/rootways/megamenu/';
    }
    
    public function getStoreCss()
    {
        $base_media = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $base_media. 'rootways/megamenu/' . 'menu_' . $this->_storeManager->getStore()->getCode() . '.css';
    }
    
    public function surl()
	{
		return "aHR0cHM6Ly9yb290d2F5cy5jb20vc2hvcC9tMl9leHRsYy5waHA=";
	}
}
