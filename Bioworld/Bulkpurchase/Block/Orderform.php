<?php
namespace Bioworld\Bulkpurchase\Block;
use Magento\Framework\View\Element\Template;
use Bss\PreOrder\Helper\Data;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Bss\ConfigurableMatrixView\Helper\Data as ConfigurableMatrixHelper;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\CatalogInventory\Api\StockStateInterface; 
use Magento\Eav\Model\Config;

class Orderform extends \Magento\Framework\View\Element\Template
{
	protected $_registry;
    protected $helper;
    protected $configurableAttribute;
    protected $configurableMatrixHelper;
    protected $priceHelper;
    protected $stockStateInterface;
    protected $config;

    public function __construct(Template\Context $context, array $data = array(),
    							\Magento\Framework\Registry $registry,
                                Data $helper,
                                Configurable $configurableAttribute,
                                ConfigurableMatrixHelper $configurableMatrixHelper,
                                PriceHelper $priceHelper,
                                StockStateInterface $stockStateInterface,
                                Config $config
								)
    {
    	$this->_registry = $registry;
        $this->helper= $helper;
        $this->configurableAttribute = $configurableAttribute;
        $this->configurableMatrixHelper=$configurableMatrixHelper;
        $this->priceHelper = $priceHelper;
        $this->stockStateInterface = $stockStateInterface;
        $this->config = $config;
    	$category = $this->_registry->registry('current_category');
        parent::__construct($context, $data);
    }

    public function getFormAction()
    {
    	return $this->getBaseUrl().'bulkpurchase/index/index/';
    }
    public function getFormatEtaDate($date)
    {
        return $this->helper->formatDate($date);
    }

    public function getConfigurableProductAttribute($product)
    {
        return $this->configurableAttribute->getConfigurableAttributesAsArray($product);
    }

    public function getSortOption()
    {
        return $this->configurableMatrixHelper->getSortOption();
    }
    public function getFinalPrice($price)
    {
        return $this->priceHelper->currency($price);
    }
    public function getStockQty($id,$websiteId)
    {
        return $this->stockStateInterface->getStockQty($id,$websiteId);
    }
    public function getAttribute($attribute,$option)
    {
        return $this->config->getAttribute($attribute,$option);
    }
}
?>
