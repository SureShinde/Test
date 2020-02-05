<?php
/**
 * Mega Menu HTML Block.
 *
 * @category  Site Search & Navigation
 * @package   Root_Mega_Menu
 * @author    Developer RootwaysInc <developer@rootways.com>
 * @copyright 2017 Rootways Inc. (https://www.rootways.com)
 * @license   Rootways Custom License
 * @link      https://www.rootways.com/shop/media/extension_doc/license_agreement.pdf
*/
namespace Rootways\Megamenu\Block;
class Main3 extends \Magento\Framework\View\Element\Template
{
    protected $_categoryHelper;
    protected $categoryFlatConfig;
    protected $topMenu;
    protected $_filterProvider;
    protected $_helper;
    protected $resourceConfig;
    protected $customCatImage;
    
    /**
     * Inherits other blocks
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Theme\Block\Html\Topmenu $topMenu,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Rootways\Megamenu\Helper\Data $helper,
        \Rootways\Megamenu\Model\Category\DataProvider\Plugin $customCatImage,
        \Magento\Config\Model\ResourceModel\Config $resourceConfig
    ) {
        $this->_categoryHelper = $categoryHelper;
        $this->categoryFlatConfig = $categoryFlatState;
        $this->topMenu = $topMenu;
        $this->_filterProvider = $filterProvider;
        $this->_customhelper = $helper;
        $this->_customcatimage = $customCatImage;
        $this->_customresourceConfig = $resourceConfig;
        parent::__construct($context);
    }
    
    /**
     * Support for get attribute value with HTML 
    */
    public function getBlockContent($content = '') {
        if(!$this->_filterProvider)
            return $content;
        return $this->_filterProvider->getBlockFilter()->filter(trim($content));
    }
   
    /**
     * Check if current page is home
    */  
    public function getIsHomePage()
    {
        $currentUrl = $this->getUrl('', ['_current' => true]);
        $urlRewrite = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $currentUrl == $urlRewrite;
    }
    
    /**
     * Return categories helper
    */   
    public function getCategoryHelper()
    {
        return $this->_categoryHelper;
    }
    
    /**
     * Return top menu html
    */   
    public function getHtml()
    {
        return $this->topMenu->getHtml();
    }
    
    /**
     * Retrieve current store categories
    */    
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }
    
    /**
    * Retrieve child store categories
    */ 
    public function getChildCategories($category)
    {
        $children = [];
        if ($this->categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }
        foreach($subcategories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $children[] = $category;
        }
        return $children; 
    }
    
    /**
     * Simple Mega Menu HTML Block.
    */
    public function simpletMenu($category)
	{
        $categoryHelper = $this->getCategoryHelper();
		$catHtml = '';
        // 2nd Level Category
        if ($childrenCategories = $this->getChildCategories($category)) {
			$catHtml .= '<ul class="rootmenu-submenu">';
            foreach ($childrenCategories as $childCategory) {
			    $collection_sub = $this->getChildCategories($childCategory);
                if (count($collection_sub)) {
                    $arrow = '<span class="cat-arrow"></span>';
                } else { 
                    $arrow = '';
                }
				$catHtml .= '<li><a href="'.$categoryHelper->getCategoryUrl($childCategory).'">'.$childCategory->getName().$arrow.'</a>';
                    
                    // 3rd Level Category
					if (count($collection_sub)) {
						$catHtml .= '<ul class="rootmenu-submenu-sub">';
							foreach ($collection_sub as $childCategory2) {
								$collection_sub_sub = $this->getChildCategories($childCategory2);
                                if (count($collection_sub_sub)) {
                                    $arrow = '<span class="cat-arrow"></span>';
                                } else {
                                    $arrow = '';
                                }
                                $catHtml .= '<li><a href="'.$categoryHelper->getCategoryUrl($childCategory2).'">'.$childCategory2->getName().$arrow.'</a>';
                                
                                // 4th Level Category
                                if (count($collection_sub_sub)) {
									$catHtml .= ' <ul class="rootmenu-submenu-sub-sub">';
										foreach ($collection_sub_sub as $childCategory3) {
                                            $catHtml .= '<li><a href="'.$categoryHelper->getCategoryUrl($childCategory3).'">'.$childCategory3->getName().'</a></li>';
										 }
									$catHtml .= '</ul>';
								}
								$catHtml .= '</li>';
							 }
						$catHtml .= '</ul>';
					}
				$catHtml .= '</li>';
			}
			$catHtml .= '</ul>';
		}
		return $catHtml;
	}
    
    /**
     * Mega Dropdown HTML Block.
    */
    public function megadropdown($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
        $colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 1;
        }
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
        // 2nd Level Category
        if ($childrenCategories = $this->getChildCategories($category)) {
			$catHtml .= '<ul class="rootmenu-submenu dropdownmega">';
            foreach ($childrenCategories as $childCategory) {
                $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
			    $childrenCategories_2 = $this->getChildCategories($childCategory);
                if (count($childrenCategories_2)) {
                    $arrow = '<span class="cat-arrow"></span>';
                } else { 
                    $arrow = '';
                }
				$catHtml .= '<li><a href="'.$categoryHelper->getCategoryUrl($childCategory).'">'.$load_cat->getName().$arrow.'</a>';
                    
                    // 3rd Level Category
					if (count($childrenCategories_2)) {
						$catHtml .= '<div class="dropdownmega_subcat">';
                            if ( $left_width != 0 ) {
                                $catHtml .= '<div class="'.$left_content_area.' clearfix rootmegamenu_block">';
                                    $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_leftblock'));
                                $catHtml .= '</div>';   
                            }
                            $catHtml .= '<div class="'.$category_area_width.' grid clearfix">';
                                $cat_cnt = 1;
                                foreach ($childrenCategories_2 as $childCategory2) {
                                    //$catHtml .= '<div class="grid-item clearfix">';
                                    $catHtml .= '<div class="grid-item-'.$colnum.' clearfix ">';
                                        $load_cat2 = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        $load_cat2->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                        $imageurl = $load_cat2->getImageUrl(); 
                                        if ( $main_cat->getMegamenuShowCatimage() == 1 && $imageurl != '' ) {
                                            $catHtml .= '<a href='.$load_cat2->getURL().' class="catproductimg"><img width='.$main_cat->getMegamenuShowCatimageWidth().' height='.$main_cat->getMegamenuShowCatimageHeight().' src='.$imageurl.' alt="'.$main_cat->getName().'"/></a>';
                                        }

                                        $catHtml .= '<div class="title"><a href='.$load_cat2->getURL().'>'.$load_cat2->getName().'</a></div>';
                                        $catHtml .= '<ul>';
                                            // 4th Level Category
                                            if ($childrenCategories_3 = $this->getChildCategories($childCategory)) {
                                                foreach ( $childrenCategories_3 as $childCategory3 ) {
                                                    $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory3->getId());
                                                    $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                                    $sub_imageurl = $load_cat_sub->getImageUrl();
                                                    $sub_datasrc = '';
                                                    if ( $sub_imageurl != '' ) {
                                                        $sub_datasrc .= 'data-src='.$sub_imageurl;
                                                        //$sub_datasrc = $sub_imageurl;
                                                    } elseif ($imageurl != '') {
                                                        $sub_datasrc .= 'data-src='.$imageurl;
                                                        //$sub_datasrc = $imageurl;
                                                    }
                                                    $catHtml .= '<li><a '.$sub_datasrc.' href='.$load_cat_sub->getURL().'>'.$load_cat_sub->getName().'</a></li>';
                                                }
                                            }
                                        $catHtml .= '</ul>';
                                    $catHtml .= '</div>';
                                    /*
                                    if ( $cat_cnt%$rightcol_type_num_of_col==0 ) {
                                        $catHtml .= '<div class="clearfix"></div>';
                                    }
                                    */
                                    $cat_cnt++;
                                }
                        
                        
                            $catHtml .= '</div>';
                            if ( $right_width != 0 ) {
                                $catHtml .= '<div class="'.$right_content_area.' clearfix rootmegamenu_block">';
                                    $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_rightblock'));
                                $catHtml .= '</div>';
                            }
						$catHtml .= '</div>';
					}
				$catHtml .= '</li>';
			}
			$catHtml .= '</ul>';
		}
		return $catHtml;
	}
    
    /**
     * Dropdown with Title Menu HTML Block.
    */
    public function dropdownTitle($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
        $colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 1;
        }
        /*
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
		*/
        // 2nd Level Category
        if ($childrenCategories = $this->getChildCategories($category)) {
			$catHtml .= '<div class="halfmenu dropdowntitle clearfix">';
                if ( $main_cat->getMegamenuTypeHeader() != '' ) {
                    $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_header'));
				    $catHtml .= '</div>';   
                }
                $catHtml .= '<div class="root-col-1 clearfix">';
                    
                    if ( $main_cat->getMegamenuShowCatimageImg() != '' ) {
                        $main_imageurl = $this->_customcatimage->getThumbnailUrl($main_cat->getMegamenuShowCatimageImg());
                    } else {
                        $main_imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                    }
                    $catHtml .= '<div class="root-sub-col-6 clearfix rootmegamenu_block">';
                        $catHtml .= '<img style="width:'.$main_cat->getMegamenuShowCatimageWidth().'px; height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" src='.$main_imageurl.' alt="'.$main_cat->getName().'"/>';
                        $catHtml .= '<div class="title"><a href="'.$main_cat->getURL().'">'.$main_cat->getName().'</a></div>';
                    $catHtml .= '</div>';
                    
                    $catHtml .= '<div class="root-sub-col-6 clearfix">';
                        $catHtml .= '<ul class="root-col-'.$colnum.' clearfix level2-popup">';
                        $cnt = 1;
                        $cat_tot = count($childrenCategories);
                        $brk = ceil($cat_tot/$colnum);
                        // 3rd Level Category
                        foreach ($childrenCategories as $childCategory) {
                            $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                            $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');

                            if ( $main_cat->getMegamenuShowCatimage() == 1 ) {
                                if ( $load_cat->getMegamenuShowCatimageImg() != '' ) {
                                    $imageurl = $this->_customcatimage->getThumbnailUrl($load_cat->getMegamenuShowCatimageImg());
                                } else {
                                    $imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                }	
                                $image_html = '<img style="width:'.$main_cat->getMegamenuShowCatimageWidth().'px; height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" src='.$imageurl.' alt="'.$load_cat->getName().'"/>';
                            } else { 
                                $image_html = '';
                            }
                            
                            $catHtml .= '<li><a href='.$load_cat->getURL().'>';
                            $catHtml .= $image_html;
                            $catHtml .= '<span class="sub-cat-name" style="height:'.$main_cat->getMegamenuShowCatimageWidth().'px;">'.$load_cat->getName().'</span>';

                            if ( $childrenCategories_2 = $this->getChildCategories($childCategory) ) {
                                $catHtml .= '<span class="cat-arrow"></span>';
                            }
                            $catHtml .='</a>';
                            if ( $childrenCategories_2 = $this->getChildCategories($childCategory) ) {
                                $catHtml .= '<span class="rootmenu-click"><i class="rootmenu-arrow"></i></span>';
                            }
                            if( $childrenCategories_2 = $this->getChildCategories($childCategory) ){
                                $catHtml .= '<ul class="level3-popup halfwidth-popup-sub-sub">';
                                    foreach ( $childrenCategories_2 as $childCategory2 ) {
                                        //$load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        //$catHtml .= '<li><a href='.$load_cat_sub->getURL().'>'.$load_cat_sub->getName().'</a></li>';
                                        
                                        $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                        if ($main_cat->getMegamenuShowCatimage() == 1) {
                                            if ( $load_cat_sub->getMegamenuShowCatimageImg() != '' ) { 
                                                $imageurl_sub = $this->_customcatimage->getThumbnailUrl($load_cat_sub->getMegamenuShowCatimageImg());
                                            } else {
                                                $imageurl_sub = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                            }
                                            $image_html_sub = '<img style="width:25px; height:25px;" src='.$imageurl_sub.' alt=""/>';
                                        } else { 
                                            $image_html_sub = ''; 
                                        }

                                        $catHtml .= '<li><a class="clearfix" href='.$load_cat_sub->getURL().'>';
                                        $catHtml .= $image_html_sub;
                                        $catHtml .= '<span class="level3-name">'.$load_cat_sub->getName().'</span>';
                                        $catHtml .= '</a></li>';
                                    }
                                $catHtml .= '</ul>';
                            }

                            $catHtml .=  '</li>';
                            if ( $cnt%$brk == 0 && $cnt != $cat_tot ) { $catHtml .= '</ul><ul  class="root-col-'.$colnum.' clearfix level2-popup">'; }
                            $cnt ++;
                        }
                        $catHtml .= '</ul>';
                    $catHtml .= '</div>';
                $catHtml .= '</div>';
                if ( $main_cat->getMegamenuTypeFooter() != '' ) {
                    $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_footer'));
                    $catHtml .= '</div>';   
                }  
			$catHtml .= '</div>';
		}
		return $catHtml;
	}
    
    /**
     * Half-Width Mega Menu HTML Block.
    */
    public function halfMenu($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        
        $catHtml = '';
        
        $colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 2;
        }
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
        
        // 2nd Level Category
		if ($childrenCategories = $this->getChildCategories($category)) {
			$catHtml .= '<div class="halfmenu clearfix">';
                if ( $main_cat->getMegamenuTypeHeader() != '' ) {
                    $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_header'));
				    $catHtml .= '</div>';   
                }
                $catHtml .= '<div class="root-col-1 clearfix">';
                    if ( $left_width != 0 ) {
                        $catHtml .= '<div class="'.$left_content_area.' clearfix rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_leftblock'));
                        $catHtml .= '</div>';   
                    }
                    $catHtml .= '<div class="'.$category_area_width.' clearfix">';
                        $catHtml .= '<ul class="root-col-'.$colnum.' clearfix level2-popup">';
                        $cnt = 1;
                        $cat_tot = count($childrenCategories);
                        $brk = ceil($cat_tot/$colnum);
                        // 3rd Level Category
                        foreach ($childrenCategories as $childCategory) {
                            $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                            $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
                            if ( $main_cat->getMegamenuShowCatimage() == 1 ) {
                                if ( $load_cat->getMegamenuShowCatimageImg() != '' ) {
                                    $imageurl = $this->_customcatimage->getThumbnailUrl($load_cat->getMegamenuShowCatimageImg());
                                } else {
                                    $imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                }	
                                $image_html = '<img style="width:'.$main_cat->getMegamenuShowCatimageWidth().'px; height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" src='.$imageurl.' alt="'.$load_cat->getName().'"/>';
                            } else { 
                                $image_html = '<span class="cat-arrow"></span>';
                                //$image_html  = '<i aria-hidden="true" class="verticalmenu-arrow fa fa-angle-right"></i>';
                            }
                            
                            $catHtml .= '<li><a href='.$load_cat->getURL().'>';
                            $catHtml .= $image_html;
                            $catHtml .= '<span class="sub-cat-name" style="height:'.$main_cat->getMegamenuShowCatimageWidth().'px;">'.$load_cat->getName().'</span>';

                            if ( $childrenCategories_2 = $this->getChildCategories($childCategory) ) {
                                $catHtml .= '<span class="cat-arrow"></span>';
                                //$catHtml .='<i class="halfwidth-dropdown-arrow fa fa-caret-right" aria-hidden="true"></i>';
                            }
                            $catHtml .='</a>';
                            if ( $childrenCategories_2 = $this->getChildCategories($childCategory) ) {
                                $catHtml .= '<span class="rootmenu-click"><i class="rootmenu-arrow"></i></span>';
                                //$catHtml .='<i class="halfwidth-dropdown-arrow fa fa-caret-right" aria-hidden="true"></i>';
                            }
                            if( $childrenCategories_2 = $this->getChildCategories($childCategory) ){
                                $catHtml .= '<ul class="level3-popup halfwidth-popup-sub-sub">';
                                    foreach ( $childrenCategories_2 as $childCategory2 ) {
                                        //$load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        //$catHtml .= '<li><a href='.$load_cat_sub->getURL().'>'.$load_cat_sub->getName().'</a></li>';
                                        
                                        $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                        if ($main_cat->getMegamenuShowCatimage() == 1) {
                                            if ( $load_cat_sub->getMegamenuShowCatimageImg() != '' ) { 
                                                $imageurl_sub = $this->_customcatimage->getThumbnailUrl($load_cat_sub->getMegamenuShowCatimageImg());
                                            } else {
                                                $imageurl_sub = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                            }
                                            $image_html_sub = '<img style="width:25px; height:25px;" src='.$imageurl_sub.' alt=""/>';
                                        } else { 
                                            $image_html_sub = ''; 
                                        }

                                        $catHtml .= '<li><a class="clearfix" href='.$load_cat_sub->getURL().'>';
                                        $catHtml .= $image_html_sub;
                                        $catHtml .= '<span class="level3-name">'.$load_cat_sub->getName().'</span>';
                                        $catHtml .= '</a></li>';
                                    }
                                $catHtml .= '</ul>';
                            }

                            $catHtml .=  '</li>';
                            if ( $cnt%$brk == 0 && $cnt != $cat_tot ) { $catHtml .= '</ul><ul  class="root-col-'.$colnum.' clearfix level2-popup">'; }
                            $cnt ++;
                        }
                        $catHtml .= '</ul>';
                    $catHtml .= '</div>';
                    if ( $right_width != 0 ) {
                        $catHtml .= '<div class="'.$right_content_area.' clearfix rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_rightblock'));
                        $catHtml .= '</div>';
                    }
                $catHtml .= '</div>';
                if ( $main_cat->getMegamenuTypeFooter() != '' ) {
                    $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_footer'));
                    $catHtml .= '</div>';   
                }  
			$catHtml .= '</div>';
		}
		return $catHtml;
	}
	
    /**
     * Half-Width With Title Mega Menu HTML Block.
    */
    public function halfTitleMenu($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
		$colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 2;
        }
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
        
        if ($childrenCategories = $this->getChildCategories($category)) {
            $catHtml .= '<div class="halfmenu clearfix">';
            
                if ( $main_cat->getMegamenuTypeHeader() != '' ) {
                    $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_header'));
				    $catHtml .= '</div>';   
                }
                $catHtml .= '<div class="root-col-1 clearfix">';
                    if ( $left_width != 0 ) {
                        $catHtml .= '<div class="'.$left_content_area.' clearfix rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_leftblock'));
                        $catHtml .= '</div>';   
                    }
                    $catHtml .= '<div class="'.$category_area_width.' grid clearfix">';
                        $cat_cnt = 1;
                        // 2nd Level Category
                        foreach ($childrenCategories as $childCategory) {
                            $catHtml .= '<div class="root-col-'.$colnum.' clearfix ">';
                                $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                                $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                $imageurl = $load_cat->getImageUrl(); 
                                if ( $main_cat->getMegamenuShowCatimage() == 1 && $imageurl != '' ) {
                                    $catHtml .= '<a href='.$load_cat->getURL().' class="catproductimg"><img width='.$main_cat->getMegamenuShowCatimageWidth().' height='.$main_cat->getMegamenuShowCatimageHeight().' src='.$imageurl.' alt="'.$main_cat->getName().'"/></a>';
                                }

                                $catHtml .= '<div class="title"><a href='.$load_cat->getURL().'>'.$load_cat->getName().'</a></div>';
                                $catHtml .= '<ul>';
                                    // 3th Level Category
                                    if ($childrenCategories_2 = $this->getChildCategories($childCategory)) {
                                        foreach ( $childrenCategories_2 as $childCategory2 ) {
                                            $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                            $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                            $sub_imageurl = $load_cat_sub->getImageUrl();
                                            $sub_datasrc = '';
                                            if ( $sub_imageurl != '' ) {
                                                $sub_datasrc .= 'data-src='.$sub_imageurl;
                                                //$sub_datasrc = $sub_imageurl;
                                            } elseif ($imageurl != '') {
                                                $sub_datasrc .= 'data-src='.$imageurl;
                                                //$sub_datasrc = $imageurl;
                                            }
                                            $catHtml .= '<li><a '.$sub_datasrc.' href='.$load_cat_sub->getURL().'>'.$load_cat_sub->getName().'</a></li>';
                                        }
                                    }
                                $catHtml .= '</ul>';
                            $catHtml .= '</div>';
                            /*
                            if ( $cat_cnt%$rightcol_type_num_of_col==0 ) {
                                $catHtml .= '<div class="clearfix"></div>';
                            }
                            */
                            $cat_cnt++;
                        }
                        $catHtml .= '</div>';

                    if ( $right_width != 0 ) {
                        $catHtml .= '<div class="'.$right_content_area.' clearfix rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_rightblock'));
                        $catHtml .= '</div>';
                    }
                $catHtml .= '</div>';
                
                if ( $main_cat->getMegamenuTypeFooter() != '' ) {
                    $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_footer'));
                    $catHtml .= '</div>';   
                }        
			$catHtml .= '</div>';
		}
		return $catHtml;
	}
    
    /**
     * Full-Width Mega Menu HTML Block.
    */
	public function fullWidthMenu($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
        $colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 2;
        }
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
        
		if ( $childrenCategories = $this->getChildCategories($category) ) {
			$catHtml .= '<div class="megamenu fullmenu clearfix linksmenu">';
                if ( $main_cat->getMegamenuTypeHeader() != '' ) {
                    $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_header'));
				    $catHtml .= '</div>';   
                }
                $catHtml .= '<div class="root-col-1 clearfix">';
                    if ( $left_width != 0 ) {
                        $catHtml .= '<div class="'.$left_content_area.' clearfix rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_leftblock'));
                        $catHtml .= '</div>';   
                    }
                    $catHtml .= '<div class="'.$category_area_width.' clearfix">';
                        $catHtml .= '<ul class="root-col-'.$colnum.' clearfix level2-popup">';
                        $cnt = 1;
                        $cat_tot = count($childrenCategories);
                        $brk = ceil($cat_tot/$colnum);
                        // 2rd Level Category
                        foreach ($childrenCategories as $childCategory) {
                            $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                            $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');

                            if ( $main_cat->getMegamenuShowCatimage() == 1 ) {
                                if ($load_cat->getImage() != '') {
                                    $imageurl = $load_cat->getImageUrl();
                                } else {  
                                    $imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                }
                                $image_html = '<img style="width:'.$main_cat->getMegamenuShowCatimageWidth().'px; height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" src='.$imageurl.' alt="'.$load_cat->getName().'"/>';
                            } else { 
                                $image_html = '<span class="cat-arrow"></span>';
                                //$image_html = '<i aria-hidden="true" class="verticalmenu-arrow fa fa-angle-right"></i>';
                            }

                            $catHtml .= '<li><a href='.$load_cat->getURL().'>';
                            $catHtml .= $image_html;
                            $catHtml .= '<span class="sub-cat-name" style="height:'.$main_cat->getMegamenuShowCatimageHeight().'px;">'.$load_cat->getName();
                            $catHtml .= '</span>';
                            if( $childrenCategories_2 = $this->getChildCategories($childCategory) ){
                                $catHtml .= '<span class="cat-arrow"></span>';
                            }
                             $catHtml .= '</a>';
                            if( $childrenCategories_2 = $this->getChildCategories($childCategory) ){
                                $catHtml .= '<span class="rootmenu-click"><i class="rootmenu-arrow"></i></span>';
                            }

                            if( $childrenCategories_2 = $this->getChildCategories($childCategory) ){
                                $catHtml .= '<ul class="level3-popup">';
                                    foreach ($childrenCategories_2 as $childCategory2) {
                                        $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                        if ( $main_cat->getMegamenuShowCatimage() == 1 ) {
                                            if ( $load_cat_sub->getImageUrl() != '' ) { 
                                                $imageurl_sub = $load_cat_sub->getImageUrl();
                                            } else {
                                                $imageurl_sub = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                            }
                                            $image_html_sub = '<img style="width:25px; height:25px;" src='.$imageurl_sub.' alt="'.$load_cat_sub->getName().'"/>';
                                        } else { 
                                            $image_html_sub = ''; 
                                        }
                                        $catHtml .= '<li><a href='.$load_cat_sub->getURL().'>';
                                        $catHtml .= $image_html_sub;
                                        $catHtml .= '<span class="level3-name">'.$load_cat_sub->getName().'</span>';
                                        $catHtml .='</a></li>';
                                    }
                                $catHtml .= '</ul>';
                            }

                            $catHtml .=  '</li>';
                            if ($cnt%$brk == 0 && $cnt != $cat_tot) { $catHtml .= '</ul><ul class="root-col-'.$colnum.' clearfix level2-popup">';}
                            $cnt ++;
                        }

                        $catHtml .= '</ul>';
                    $catHtml .= '</div>';
                    if ( $right_width != 0 ) {
                        $catHtml .= '<div class="'.$right_content_area.' clearfix rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_rightblock'));
                        $catHtml .= '</div>';
                    }
                $catHtml .= '</div>';
                if ( $main_cat->getMegamenuTypeFooter() != '' ) {
                    $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_footer'));
                    $catHtml .= '</div>';   
                }
			$catHtml .= '</div>';
		}
		return $catHtml;
	}
    
    /**
     * Full-Width With Right Side Content Mega Menu HTML Block.
    */
	public function fullTitleMenu($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
		$colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 2;
        }
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
        if ($childrenCategories = $this->getChildCategories($category)) {
			$catHtml .= '<div class="megamenu fullmenu clearfix categoriesmenu">';
                if ( $main_cat->getMegamenuTypeHeader() != '' ) {
                    $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_header'));
				    $catHtml .= '</div>';   
                }
                $catHtml .= '<div class="root-col-1 clearfix">';
                    if ( $left_width != 0 ) {
                        $catHtml .= '<div class="'.$left_content_area.' clearfix left rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_leftblock'));
                        $catHtml .= '</div>';
                        $catHtml .= '<div class="main_categoryblockcontent">'.$this->getBlockContent($main_cat->getData('megamenu_type_leftblock')).'</div>';
                    } else {
                        $catHtml .= '<div class="main_categoryblockcontent">'.$this->getBlockContent($main_cat->getData('megamenu_type_rightblock')).'</div>';
                    }
                    $catHtml .= '<div class="'.$category_area_width.' grid clearfix">';
                        $cat_cnt = 1;
                        // 2rd Level Category
                        foreach ($childrenCategories as $childCategory) {
                            //$catHtml .= '<div class="grid-item clearfix">';
                            $catHtml .= '<div class="grid-item-'.$colnum.' clearfix ">';
                                $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                                $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                $imageurl = $load_cat->getImageUrl(); 
                                if ( $main_cat->getMegamenuShowCatimage() == 1 && $imageurl != '' ) {
                                    $catHtml .= '<a href='.$load_cat->getURL().' class="catproductimg"><img width='.$main_cat->getMegamenuShowCatimageWidth().' height='.$main_cat->getMegamenuShowCatimageHeight().' src='.$imageurl.' alt="'.$main_cat->getName().'"/></a>';
                                }

                                $catHtml .= '<div class="title"><a href='.$load_cat->getURL().'>'.$load_cat->getName().'</a></div>';
                                $catHtml .= '<ul>';
                                    // 4th Level Category
                                    if ($childrenCategories_2 = $this->getChildCategories($childCategory)) {
                                        foreach ( $childrenCategories_2 as $childCategory2 ) {
                                            $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                            $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                            $sub_imageurl = $load_cat_sub->getImageUrl();
                                            $sub_datasrc = '';
                                            if ( $sub_imageurl != '' ) {
                                                $sub_datasrc .= 'data-src='.$sub_imageurl;
                                                //$sub_datasrc = $sub_imageurl;
                                            } elseif ($imageurl != '') {
                                                $sub_datasrc .= 'data-src='.$imageurl;
                                                //$sub_datasrc = $imageurl;
                                            }
                                            $catHtml .= '<li><a '.$sub_datasrc.' href='.$load_cat_sub->getURL().'>'.$load_cat_sub->getName().'</a>';
                                                if ( $left_width != 0 && $load_cat_sub->getData('megamenu_type_leftblock') != '') {
                                                     $catHtml .= '<div class="categoryblockcontent">'.$this->getBlockContent($load_cat_sub->getData('megamenu_type_leftblock')).'</div>'; 
                                                } else if ($right_width != 0 && $load_cat_sub->getData('megamenu_type_rightblock') != '') {
                                                    $catHtml .= '<div class="categoryblockcontent">'.$this->getBlockContent($load_cat_sub->getData('megamenu_type_rightblock')).'</div>';
                                                } else { }
                                            $catHtml .= '</li>';
                                        }
                                    }
                                $catHtml .= '</ul>';
                            $catHtml .= '</div>';
                            /*
                            if ( $cat_cnt%$rightcol_type_num_of_col==0 ) {
                                $catHtml .= '<div class="clearfix"></div>';
                            }
                            */
                            $cat_cnt++;
                        }
                    $catHtml .= '</div>';
                    if ( $right_width != 0 ) {
                        $catHtml .= '<div class="'.$right_content_area.' clearfix right rootmegamenu_block">';
                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_rightblock'));
                        $catHtml .= '</div>';
                    }
                $catHtml .= '</div>';
                if ( $main_cat->getMegamenuTypeFooter() != '' ) {
                    $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                        $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_footer'));
                    $catHtml .= '</div>';   
                }
			$catHtml .= '</div>';
		}
		return $catHtml;
	}
	
    /**
     * Tabbing Mega Menu HTML Block.
    */  	
	public function tabMenu($category)
	{
		$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
        $colnum = $main_cat->getMegamenuTypeNumofcolumns();
		if ( $colnum == 0 ) {
            $colnum = 5;
        }
        $left_width = $main_cat->getMegamenuTypeLeftblockW();
        $right_width = $main_cat->getMegamenuTypeRightblockW();
        $cat_width = 12 - ($left_width + $right_width);
        $category_area_width = 'root-sub-col-'.$cat_width;
        $left_content_area = 'root-sub-col-'.$left_width;
        $right_content_area = 'root-sub-col-'.$right_width;
        
		$catHtml = '';
		if ($childrenCategories = $this->getChildCategories($category)) {
			$catHtml .= '<div class="megamenu fullmenu clearfix tabmenu">';
			$catHtml .= '<div class="mainmenuwrap clearfix">';
			$catHtml .= '<ul class="root-col-1 clearfix vertical-menu">';
				$cnt = 0;
                 // 2nd Level Category
				foreach ($childrenCategories as $childCategory) {
					$load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                    $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
                    
                    $left_sub_width = $load_cat->getMegamenuTypeLeftblockW();
                    $right_sub_width = $load_cat->getMegamenuTypeRightblockW();
                    $cat_sub_width = 12 - ($left_sub_width + $right_sub_width);
                    $sub_category_area_width = 'root-sub-col-'.$cat_sub_width;
                    $sub_left_content_area = 'root-sub-col-'.$left_sub_width;
                    $sub_right_content_area = 'root-sub-col-'.$right_sub_width;
                    if ($left_sub_width != 0 || $right_sub_width != 0) {
                        $category_area_width = 'root-sub-col-'.$cat_sub_width;
                    }
					
					$imageurl = $load_cat->getImageUrl();
					$catHtml .= '<li class="clearfix"><a href='.$load_cat->getUrl().' class="root-col-4">'.$load_cat->getName().'<span class="cat-arrow"></span></a>';
                    if ($cnt == 0) {
                        $open = "openactive";
                    } else {
                        $open = "";
                    } $cnt++;
                    if ($childrenCategories_2 = $this->getChildCategories($childCategory)) {
						$catHtml .= '<div class="root-col-75 verticalopen '.$open.'">';
                            if ( $load_cat->getMegamenuTypeHeader() != '' ) {
                                $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                                    $catHtml .= $this->getBlockContent($load_cat->getData('megamenu_type_header'));
                                $catHtml .= '</div>';   
                            } elseif ( $main_cat->getMegamenuTypeHeader() != '' ) {
                                $catHtml .= '<div class="menuheader root-col-1 clearfix">';
                                    $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_header'));
                                $catHtml .= '</div>';   
                            }
                            $catHtml .= '<div class="root-col-1 clearfix">';
                                if ( $left_width != 0 || $left_sub_width != 0 ) {
                                    $left_sub_content = $this->getBlockContent($load_cat->getData('megamenu_type_leftblock'));
                                    if ($left_sub_content != '') {
                                        $catHtml .= '<div class="'.$sub_left_content_area.' clearfix rootmegamenu_block">';
                                            $catHtml .= $left_sub_content;
                                        $catHtml .= '</div>';   
                                    } else {
                                        $catHtml .= '<div class="'.$left_content_area.' clearfix rootmegamenu_block">';
                                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_leftblock'));
                                        $catHtml .= '</div>';
                                    }
                                }
                                $catHtml .= '<div class="'.$category_area_width.' clearfix">';
                                    $sub_cnt = 1;
                                    // 3th Level Category
                                    foreach ($childrenCategories_2 as $childCategory2) {

                                        if ($main_cat->getMegamenuShowCatimage() == 1) {
                                            $brake_point = $colnum * 2;
                                        } else {
                                            $brake_point = $colnum * 6;	
                                        }
                                        if ($sub_cnt > $brake_point) { continue; }
                                        $sub_cnt++;
                                        $load_cat_sub = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                        $load_cat_sub->getCollection()->addAttributeToFilter('include_in_menu', '1');

                                        $catHtml .= '<div class="tabimgwpr root-col-'.$colnum.'"><a href='.$load_cat_sub->getURL().' class="tabimtag">';
                                        if ($main_cat->getMegamenuShowCatimage() == 1) {
                                            if ($load_cat_sub->getImageUrl() != '') {
                                                $imageurl = $load_cat_sub->getImageUrl(); 
                                            } else { 
                                                $imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                            }
                                            $catHtml .= '<img width='.$main_cat->getMegamenuShowCatimageWidth().' height='.$main_cat->getMegamenuShowCatimageHeight().' src='.$imageurl.' alt="'.$main_cat->getName().'"/>';
                                        }
                                        $catHtml .= '<div class="tabimgtext">'.$load_cat_sub->getName().'</div></a> </div>';
                                    }
                                    if ( $sub_cnt > $brake_point ) {
                                        $catHtml .= '<a href='.$load_cat->getURL().' class="view_all">View All &raquo;</a>';
                                    }
                                $catHtml .= '</div>';
                                if ($right_width != 0 || $right_sub_width != 0) {
                                    $right_sub_content = $this->getBlockContent($load_cat->getData('megamenu_type_rightblock'));
                                    if ($right_sub_content != '') {
                                        $catHtml .= '<div class="'.$sub_right_content_area.' clearfix rootmegamenu_block">';
                                            $catHtml .= $right_sub_content;
                                        $catHtml .= '</div>';   
                                    } else {
                                        $catHtml .= '<div class="'.$right_content_area.' clearfix rootmegamenu_block">';
                                            $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_rightblock'));
                                        $catHtml .= '</div>';
                                    }
                                }
                            $catHtml .= '</div>';
                            if ( $load_cat->getMegamenuTypeFooter() != '' ) {
                                $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                                    $catHtml .= $this->getBlockContent($load_cat->getData('megamenu_type_footer'));
                                $catHtml .= '</div>';   
                            } elseif( $main_cat->getMegamenuTypeFooter() != '' ) {
                                $catHtml .= '<div class="menufooter root-col-1 clearfix">';
                                    $catHtml .= $this->getBlockContent($main_cat->getData('megamenu_type_footer'));
                                $catHtml .= '</div>';   
                            } else { }
						$catHtml .= '</div>';
					 } else {
						$catHtml .= '<div class="root-col-75 verticalopen empty_category '.$open.'">';
						    $catHtml .= '<span>Sub-category not found for '.$load_cat->getName().' Category</span>';
						$catHtml .= '</div>';
                    }
					$catHtml .= '</li>';
				}
			$catHtml .= '</ul>';
			$catHtml .= '</div>';
			$catHtml .= '</div>';
		}
		return $catHtml;	
	}
    
    /**
     * Full-Width Horizontal Mega Menu HTML Block.
    */
    public function tabHorizontal($category)
    {
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $main_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
        $catHtml = '';
        
        if ( $childrenCategories = $this->getChildCategories($category) ) {
            $catHtml .= '<div class="megamenu fullmenu clearfix tabmenu02">';
                $catHtml.= '<div class="mainmenuwrap02 clearfix">';
                    $catHtml .= '<ul class="vertical-menu02 root-col-1 clearfix">';
                        foreach ( $childrenCategories as $childCategory ) {
                            $load_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory->getId());
                            $load_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
                            
							//if ( $cnt == 0 ) { $open_subcat = " main_openactive02"; } else { $open_subcat = ""; }
                            $catHtml .= '<li class="clearfix"><a class="clearfix" style="line-height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" href='.$load_cat->getURL().'>';
                            
							if ($main_cat->getMegamenuShowCatimage() == 1) {
								if ($load_cat_sub->getImageUrl() != '') {
									$imageurl = $load_cat_sub->getImageUrl(); 
								} else {
									$imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
								}
								$catHtml .= ' <span><img style="width:'.$main_cat->getMegamenuShowCatimageWidth().'px; height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" src='.$imageurl.' alt="'.$load_cat->getName().'"/></span>';	
							}
							$catHtml .= '<em>'.$load_cat->getName().'</em></a>';
                            if ( $childrenCategories_2 = $this->getChildCategories($childCategory) ) {
                                $num_of_col = $load_cat->getMegamenuTypeNumofcolumns();
                                if ( $num_of_col == 0 ) {
                                    $num_of_col = 3;
                                }
                                $cnt = 0;
                                $cat_tot = count($childrenCategories_2);
                                $brk = ceil($cat_tot/$num_of_col);
                                
                                if ($cnt == 0) { $open = "openactive02"; } else { $open = ""; }
                                $cnt++;
                                $catHtml .= '<div class="root-col-1 verticalopen02 '.$open.'">';
                                
                                    $content_width = $load_cat->getMegamenuTypeStaticblockW();
                                    if ( $content_width == 0 ){ 
                                        $category_area_width = 'root-sub-col-5';
                                        $content_area_width = 'root-sub-col-7';
                                    } else { 
                                        $category_area_width = 'root-sub-col-'.(12 - $content_width);
                                        $content_area_width = 'root-sub-col-'.$content_width;
                                    }
                                    
                                    $sub_cnt = 1;
                                    $catHtml .= '<div class="'.$category_area_width.' topmenu02-categories clearfix">';
                                        $catHtml .= '<div class="title"><a href="'.$load_cat->getURL().'">'.$load_cat->getName().'</a></div>';
                                        $catHtml .= '<div class="root-col-'.$num_of_col.' clearfix">';
                                            $catHtml .= '<ul class="ulliststy02">';
                                                $sub_cnt = 1;
                                                foreach ($childrenCategories_2 as $childCategory2) {
                                                    $load_sub_sub_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($childCategory2->getId());
                                                    $load_sub_sub_cat->getCollection()->addAttributeToFilter('include_in_menu', '1');
                                                    $catHtml .= '<li><a href='.$load_sub_sub_cat->getURL().'>';

                                                    if ($main_cat->getMegamenuShowCatimage() == 1) {
                                                        if ($load_sub_sub_cat->getMegamenuTypeShowimgImg() != '') { 
                                                            $imageurl = $load_sub_sub_cat->getImageUrl(); 
                                                        } else {
                                                            $imageurl = $this->getViewFileUrl('Rootways_Megamenu::images/rootimgicon.jpg');
                                                        }
                                                        $catHtml .= ' <span><img style="width:'.$main_cat->getMegamenuShowCatimageWidth().'px; height:'.$main_cat->getMegamenuShowCatimageHeight().'px;" src='.$imageurl.' alt="'.$load_sub_sub_cat->getName().'"/></span>';	
                                                    } else {
                                                        $catHtml  .= '<i aria-hidden="true" class="verticalmenu-arrow fa fa-angle-right"></i>';
                                                    }
                                                    $catHtml .= '<span>'.$load_sub_sub_cat->getName().'</span></a> </li>';

                                                    if ( $sub_cnt%$brk == 0 ) { $catHtml .= '</ul></div> <div class="root-col-'.$num_of_col.' clearfix"><ul class="ulliststy02">';}
                                                    $sub_cnt++;
                                                }
                                            $catHtml .= '</ul>';
                                        $catHtml .= '</div>';
                                    $catHtml .= '</div>';
                                    
                                    $catHtml .= '<div class="'.$content_area_width.' clearfix rootmegamenu_block">';
                                        $catHtml .= $this->getBlockContent($load_cat->getData('megamenu_type_staticblock'));
                                    $catHtml .= '</div>';
                                
                                $catHtml .= '</div>';
                             } else {
                                $catHtml .= '<div class="root-col-1 verticalopen02">';
                                    $catHtml .= '<span>There is no sub-category for '.$load_cat->getName().' category</span>';
                                $catHtml .= '</div>';
                             }
                            $catHtml .= '</li>';
                        }
                    $catHtml .= '</ul>';
                $catHtml .= '</div>';
            $catHtml .= '</div>';
        }
        return $catHtml;
    }
	
    /**
     * Product Listing Mega Menu HTML Block.
    */   
	public function productMenu($category)
	{
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryHelper = $this->getCategoryHelper();
        $main_cat = $_objectManager->create('Magento\Catalog\Model\Category')->load($category->getId());
        $products = $main_cat->getProductCollection();
        $products->addAttributeToSelect('*');
        $catHtml = '';
        
        $media_url = $_objectManager->get('Magento\Store\Model\StoreManagerInterface')
                    ->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);        
        $currencysymbol = $_objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $currency = $currencysymbol->getStore()->getCurrentCurrencyCode();
        
        /* 
        foreach ($products as $product) {
            $productRepository = $_objectManager->get('\Magento\Catalog\Model\ProductRepository');
            $product = $productRepository->getById($product->getId()); 
            //echo '<pre>Load Vish';print_r($product->getData());
            //echo $product->getName() . ' - ' . $product->getProductUrl() . '<br />';
        }
       exit;
       */
        $catHtml .= '<div class="megamenu clearfix product-thumbnail">';
			$pro_cnt = 0;
       		foreach ( $products as $product ) {
                //echo '<pre>'; print_r($product->getData());exit;
				if ( $pro_cnt > 10 ) { 
                    continue;
                }
                $pro_cnt++;
                $productRepository = $_objectManager->create('\Magento\Catalog\Model\ProductRepository');
                $_product = $productRepository->getById($product->getId()); 
                
                $catHtml .= '<div class="root-col-5 clearfix">';
					$catHtml .= '<div class="probox01imgwp">';
						$catHtml .= '<div class="proimg"><a href='.$_product->getProductUrl().'><img src='.$media_url.'catalog/product'.$_product->getImage().' alt="'.$main_cat->getName().'"></a></div>';
					$catHtml .= '</div>';
				  	$catHtml .= '<div class="proinfo clearfix">';
						$catHtml .= '<div class="proname clearfix"><a href="#">'.$_product->getName().'</a></div>';
						$catHtml .= '<div class="pricebox"> <span>'.$currency.number_format($_product['price'],2).'</span> <a href="'.$_product->getProductUrl().'" class="addtocart-but">Add to Cart</a> </div>';
					  $catHtml .= '</div>';
				$catHtml .= '</div> ';
			}
        $catHtml .= '</div>';
		return $catHtml;
    }
    
    /**
     * Act HTML Block.
    */ 
    public function act()
	{
	}
	
    /**
     * Contact Us Mega Menu HTML Block.
    */   
	public function contactus()
	{
		$catHtml = '';
		$catHtml .= '<li><a href="javascript:void(0);">'.__('Contact Us').'</a>';
			$catHtml .= '<div class="megamenu fullmenu contacthalfmenu clearfix">';
				$catHtml .= '<div class="root-col-2 clearfix">';
					$contact_content = $this->_scopeConfig->getValue('rootmegamenu_option/general/contactus_content');
                    $catHtml .= $this->getBlockContent($contact_content);
				$catHtml .= '</div>';
                $base_url = $this->_storeManager->getStore()->getBaseUrl();
					
				$catHtml .= '<div class="root-col-2 clearfix">';
					$catHtml .= '<div class="title">'.__('Contact Us').'</div>';
					$catHtml .=	'<form id="megamenu_contact_form" name="megamenu_contact_form" class="menu_form">';
						$catHtml .= '<input id="name" name="name" type="text" autocomplete="off" placeholder="'.__('Name').'">';
						$catHtml .= '<input id="menuemail" name="menuemail" type="text" autocomplete="off" placeholder="'.__('Email').'">';
						$catHtml .= '<input type="text" title="Telephone" id="telephone" name="telephone" autocomplete="off" placeholder="'.__('Telephone').'">';
						$catHtml .= '<textarea id="comment" name="comment" placeholder="'.__('Your message...').'"></textarea>';
						$catHtml .= '<input type="text" style="display:none !important;" value="" id="hideit" name="hideit">';
						$catHtml .= '<input type="text" style="display:none !important;" value="'.$base_url.'" name="base_url" id="base_url" >';
						$catHtml .= '<input onclick="rootFunction()" type="button" value="'.__('Reset').'">';
						$catHtml .= '<input id="megamenu_submit" type="submit" value="'.__('Send').'">';
					$catHtml .= '</form>';
				$catHtml .= '</div>';
			$catHtml .= '</div>';
		$catHtml .= '</li>';
			
		return $catHtml;
	}
    
    /*
    public function getValuesConfig()
    {
            return $this->_scopeConfig->getValue('rootmegamenu_option/general/licencekey');
    }
    */
    
    public function _getMenuItemAttributes($item)
    {
        $menuItemClasses = $this->_getMenuItemClasses($item);
        return implode(' ', $menuItemClasses);
    }
    
    /**
     * Get Class of categories.
    */  
    protected function _getMenuItemClasses($item)
    {
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        $classes = [];
        /*
        $classes[] = 'rootlevel' . $item->getLevel();
        $classes[] = $item->getPositionClass();


        if ($item->hasChildren()) {
            $classes[] = 'has-parent';
        }
        */
        
        $cur_cat = $_objectManager->get('Magento\Framework\Registry')->registry('current_category');
        $categoryPathIds = explode(',', $cur_cat->getPathInStore());
        if (in_array($item->getId(), $categoryPathIds) == '1') {
            $classes[] = 'active';   
        }
        return $classes;
    }
    
    /**
     * Get Class of categories.
    */  
    public function getCustomLinks($category_id)
    {
        $base_url = $this->_storeManager->getStore()->getBaseUrl();   
        $customMenus = $this->_scopeConfig->getValue('rootmegamenu_option/general/custom_link');
        $customLinkHtml = '';
        if ( $customMenus ) {
            $customMenus = json_decode($customMenus, true);
            if ( is_array($customMenus) ) {
                foreach ( $customMenus as $customMenusRow ) {
                    if ($customMenusRow['custommenulink'] != '') {
                       $no_custom_link = $base_url.$customMenusRow['custommenulink'];
                    } else {
                        $no_custom_link = 'javascript:void(0);';
                    }
                    if ( $customMenusRow['custom_menu_position'] == $category_id  && $customMenusRow['custom_menu_position'] != '' ) {
                        $customLinkHtml .= '<li class="custom-menus"><a href="'.$no_custom_link.'">'.$customMenusRow['custommenuname'].'</a>';
                        if ($customMenusRow['custom_menu_block'] != '') {
                            $customLinkHtml .= $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($customMenusRow['custom_menu_block'])->toHtml();
                        }
                        echo '</li>';   
                    }
                    
                    if ( $category_id == false && $customMenusRow['custom_menu_position'] == '') {
                        $customLinkHtml .= '<li class="custom-menus"><a href="'.$no_custom_link.'">'.$customMenusRow['custommenuname'].'</a>';
                        if ($customMenusRow['custom_menu_block'] != '') {
                            $customLinkHtml .= $this->getLayout()->createBlock('Magento\Cms\Block\Block')->setBlockId($customMenusRow['custom_menu_block'])->toHtml();
                        }
                        echo '</li>';   
                    }
                    
                }
            }
        }
        return $customLinkHtml;
    }
}
