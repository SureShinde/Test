<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Rootways\Megamenu\Observer;

use Magento\Framework\Event\ObserverInterface;

class DesignSettings implements ObserverInterface
{
    protected $_messageManager;
    protected $logger;
    
    public function __construct(
        \Rootways\Megamenu\Model\Design\Generator $cssenerator,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_design = $cssenerator;
        $this->logger = $logger;
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_design->menuCss($observer->getData("website"), $observer->getData("store"));
    }
}
