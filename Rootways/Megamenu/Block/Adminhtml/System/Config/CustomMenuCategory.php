<?php
namespace Rootways\Megamenu\Block\Adminhtml\System\Config;

class CustomMenuCategory extends \Magento\Framework\View\Element\Html\Select
{
    protected $categoryHelper;
    
    protected $_categoryHelper;
    
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_categoryHelper = $categoryHelper;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function _toHtml()
    {   
        if (!$this->getOptions()) {
            $cat = $this->getStoreCategories(true,false,true);
            $categories = $this->_categoryCollectionFactory->create();
            $categories->addAttributeToSelect('*');
            $categories->addIsActiveFilter();
            $categories->addLevelFilter(2);
            $this->addOption('', '-- Select --');
            foreach ($cat as $cat) {
                $this->addOption($cat->getId(), $cat->getName());
            }
        }

        return parent::_toHtml();
    }
    
    public function setInputName($value)
    {
        return $this->setName($value);
    }
    
    /**
     * Retrieve current store categories
    */    
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }
}
