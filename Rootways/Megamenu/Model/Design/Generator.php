<?php
namespace Rootways\Megamenu\Model\Design;

class Generator
{
    protected $_messageManager;
    protected $_coreRegistry;
    protected $_storeManager;
    protected $_layoutManager;
    protected $_io;
    protected $_cssfolder;
    
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layoutManager,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Filesystem\Io\File $io,
        \Rootways\Megamenu\Helper\Data $cssfolder
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_storeManager = $storeManager;
        $this->_layoutManager = $layoutManager;
        $this->_messageManager = $messageManager;
        $this->_io = $io;
        $this->_cssfolder = $cssfolder;
    }
    
    
     public function menuCss($websiteId, $storeId){
        if(!$websiteId && !$storeId) {
            $websites = $this->_storeManager->getWebsites(false, false);
            foreach ($websites as $id => $value) {
                $this->generateWebsiteCss($id);
            }
        } else {
            if($storeId) {
                $this->generateStoreCss($storeId);
            } else {
                $this->generateWebsiteCss($websiteId);
            }
        }        
    }
    
    protected function generateWebsiteCss($websiteId) {
        $website = $this->_storeManager->getWebsite($websiteId);
        foreach($website->getStoreIds() as $storeId){
            $this->generateStoreCss($storeId);
        }
    }
    
    protected function generateStoreCss($storeId) {
        $store = $this->_storeManager->getStore($storeId);
        if(!$store->isActive())
            return;
        
        $storeCode = $store->getCode();
        $str1 = '_'.$storeCode;
        $str2 = 'menu'.$str1.'.css';
        $str3 = $this->_cssfolder->getCssDir().$str2;
        $str4 = 'rootways/megamenu/design.phtml';
        $this->_coreRegistry->register('cssgen_store', $storeCode);

        try {
            $block = $this->_layoutManager->createBlock('Rootways\Megamenu\Block\Design')->setData('area','frontend')->setTemplate($str4)->toHtml();
            if(!file_exists($this->_cssfolder->getCssDir())) {
                $this->_io->mkdir($this->_cssfolder->getCssDir(), 0777);
            }
            $file = @fopen($str3,"w+");
            @flock($file, LOCK_EX);
            @fwrite($file,$block);
            @flock($file, LOCK_UN);
            @fclose($file);
            if(empty($block)) {
                throw new \Exception( __("Template file is empty or doesn't exist: ".$str4) );
            }
        } catch (\Exception $e) {
            $this->_messageManager->addError(__('Failed generating CSS file: '.$str2.' in '.$this->_cssfolder->getCssDir()).'<br/>Message: '.$e->getMessage());
        }
        $this->_coreRegistry->unregister('cssgen_store');
    }
}
