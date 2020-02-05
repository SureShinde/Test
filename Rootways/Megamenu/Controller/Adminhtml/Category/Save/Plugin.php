<?php
namespace Rootways\Megamenu\Controller\Adminhtml\Category\Save;

class Plugin
{           
    //add thumnail field to $data for saving
    public function afterImagePreprocessing(\Magento\Catalog\Controller\Adminhtml\Category\Save $subject, $data)
    {
        if (isset($data['megamenu_show_catimage_img']) && is_array($data['megamenu_show_catimage_img'])) {
            if (!empty($data['megamenu_show_catimage_img']['delete'])) {
                $data['megamenu_show_catimage_img'] = null;
            } else {
                if (isset($data['megamenu_show_catimage_img'][0]['name']) && isset($data['megamenu_show_catimage_img'][0]['tmp_name'])) {
                    $data['megamenu_show_catimage_img'] = $data['megamenu_show_catimage_img'][0]['name'];
                } else {
                    unset($data['megamenu_show_catimage_img']);
                }
            }
        }else{
            $data['megamenu_show_catimage_img'] = null;
        }
        
        return $data;
    }

}
