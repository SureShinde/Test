<?php
namespace Rootways\Megamenu\Block\Adminhtml\System\Config;

class CustomMenuBlock extends \Magento\Framework\View\Element\Html\Select
{
    protected $blockFactory;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_blockFactory = $blockFactory;
    }

    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $cmsBlocks = $this->_blockFactory->create()->getCollection();
            $this->addOption('', '-- No Dropdown --');
            foreach ($cmsBlocks as $block) {
                //$this->addOption($attribute['value'], $attribute['label']);
                $this->addOption($block->getIdentifier(), $block->getTitle());
            }
        }

        return parent::_toHtml();
    }
    
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}
