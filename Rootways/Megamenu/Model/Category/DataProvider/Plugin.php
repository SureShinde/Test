<?php
namespace Rootways\Megamenu\Model\Category\DataProvider;

class Plugin
{       
    protected $_storeManager;

    public function __construct(        
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {       
        $this->_storeManager = $storeManager;    
    }

    //retrieve thumnail data for output
    public function afterGetData(\Magento\Catalog\Model\Category\DataProvider $subject, $result)
    {
        $category = $subject->getCurrentCategory();
        $categoryData = $result[$category->getId()];

        if (isset($categoryData['megamenu_show_catimage_img'])) {
            unset($categoryData['megamenu_show_catimage_img']);
            $categoryData['megamenu_show_catimage_img'][0]['name'] = $category->getData('megamenu_show_catimage_img');
            $categoryData['megamenu_show_catimage_img'][0]['url'] = $this->getThumbnailUrl($category->getData('megamenu_show_catimage_img'));
        }

        $result[$category->getId()] = $categoryData;
        
        return $result;
    }

    public function getThumbnailUrl($imageName){
        $url = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'catalog/category/' . $imageName;
        return $url;
    }
}
