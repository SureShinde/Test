<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category  BSS
 * @package   Bss_LayerNavigation
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 BSS Commerce Co. ( http://bsscommerce.com )
 * @license   http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\LayerNavigation\Model\Plugin;

class FilterList
{
    const RATING_FILTER = 'layer_rating';
    const STATE_FILTER = 'layer_state';

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var
     */
    protected $customFilter;

    /**
     * @var array
     */
    protected $filterTypes = [
        self::RATING_FILTER => 'Bss\LayerNavigation\Model\ResourceModel\Rating'
    ];

    /**
     * @var \Bss\LayerNavigation\Model\ResourceModel\RatingFactory
     */
    protected $rating;


    /**
     * @var \Bss\LayerNavigation\Helper\Data
     */
    protected $helper;

    /**
     * FilterList constructor.
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Bss\LayerNavigation\Helper\Data $helper
     * @param \Bss\LayerNavigation\Model\ResourceModel\RatingFactory $rating
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Bss\LayerNavigation\Helper\Data $helper,
        \Bss\LayerNavigation\Model\ResourceModel\RatingFactory $rating
    ) {
        $this->rating = $rating;
        $this->helper = $helper;
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Magento\Catalog\Model\Layer\FilterList $subject
     * @param \Closure $proceed
     * @param \Magento\Catalog\Model\Layer $layer
     * @return array|mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetFilters(
        \Magento\Catalog\Model\Layer\FilterList $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Layer $layer
    ) {
        $filter = $proceed($layer);

        if (!$this->helper->isEnabled()) {
            return $filter;
        }

        if (!$this->customFilter) {
            $customFilter = [];

            if ($this->helper->isRating()) {
                $customFilter[] = $this->rating->create(['layer' => $layer]);
            }

            $this->customFilter = $customFilter;
        }

        if (sizeof($this->customFilter)) {
            $filter = array_merge($filter, $this->customFilter);
        }

        return $filter;
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    protected function sortFilter($a, $b)
    {
        $aPosition = $this->getPosition($a);
        $bPosition = $this->getPosition($b);

        return ($aPosition >= $bPosition) ? 1 : -1;
    }

    /**
     * @param $object
     * @return int
     */
    private function getPosition($object)
    {
        $attribute = $object->hasAttributeModel() ? $object->getAttributeModel() : null;
        $position  = $object->hasPosition() ? $object->getPosition() : ($attribute ? $attribute->getPosition() : 0);

        return $position;
    }
}
