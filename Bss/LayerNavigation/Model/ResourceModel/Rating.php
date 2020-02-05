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
namespace Bss\LayerNavigation\Model\ResourceModel;

use Magento\Catalog\Model\Layer\Filter\AbstractFilter;

class Rating extends AbstractFilter
{
    /**
     * @var string
     */
    protected $_requestVar;

    /**
     * @var string
     */
    protected $productRatingCollection;

    /**
     * Rating constructor.
     * @param \Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Layer $layer
     * @param \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder
     * @param array $data
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        \Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Layer $layer,
        \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder,
        array $data = []
    ) {
        parent::__construct($filterItemFactory, $storeManager, $layer, $itemDataBuilder, $data);
        $this->_requestVar   = 'rating';
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return $this|AbstractFilter
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {
        $this->setData('filter_type', 'rating');
        $this->setData('multiple_mode', false);
        $productCollection = $this->getLayer()->getProductCollection();
        
        $filter = $request->getParam($this->_requestVar);
        if (!$filter) {
            return $this;
        }

        $productCollectionCloneRating = $productCollection->getCollectionClone();
        $this->productRatingCollection = $productCollectionCloneRating;

        $productCollection->getSelect()
            ->joinLeft(
                ['rt' => $productCollection->getTable('review_entity_summary')],
                "e.entity_id = rt.entity_pk_value AND rt.store_id = " . $this->_storeManager->getStore()->getId(),
                ['rating_summary']
            );
        
        $from = (int)$filter*20;
        $to = 100;

        $productCollection->getSelect()->where('rt.rating_summary <= '.$to);
        $productCollection->getSelect()->where('rt.rating_summary >= '.$from);

        $this->getLayer()->getState()->addFilter($this->_createItem($this->getOptionText($filter), $filter));

        return $this;
    }

    /**
     * @param int $optionId
     * @return \Magento\Framework\Phrase
     */
    protected function getOptionText($optionId)
    {
        if ($optionId == 1) {
            return __('%1 star & up', $optionId);
        }

        return __('%1 stars & up', $optionId);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Rating';
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _getItemsData()
    {
        $s1 = '<div class="rating-summary" style="display: inline-block; margin-top: -8px; vertical-align: middle;">
                <div class="rating-result" title="20%">
                    <span style="width:20%"><span>1</span></span>
                </div>
            </div>';

        $s2 = '<div class="rating-summary" style="display: inline-block; margin-top: -8px; vertical-align: middle;">
                <div class="rating-result" title="40%">
                    <span style="width:40%"><span>2</span></span>
                </div>
            </div>';

        $s3 = '<div class="rating-summary" style="display: inline-block; margin-top: -8px; vertical-align: middle;">
                    <div class="rating-result" title="60%">
                        <span style="width:60%"><span>3</span></span>
                    </div>
                </div>';

        $s4 = '<div class="rating-summary" style="display: inline-block; margin-top: -8px; vertical-align: middle;">
                    <div class="rating-result" title="80%">
                        <span style="width:80%"><span>4</span></span>
                    </div>
                </div>';

        $s5 = '<div class="rating-summary" style="display: inline-block; margin-top: -8px; vertical-align: middle;">
                    <div class="rating-result" title="100%">
                        <span style="width:100%"><span>5</span></span>
                    </div>
                </div>';

        $ratingStep = [
            '1' => $s1,
            '2' => $s2,
            '3' => $s3,
            '4' => $s4,
            '5' => $s5,
        ];

        if ($this->productRatingCollection) {
            $productCollection = $this->productRatingCollection;
        } else {
            $productCollection = $this->getLayer()->getProductCollection();
        }

        foreach ($ratingStep as $step => $label) {
            $productCollectionClone = $productCollection->getCollectionClone();
            $productCollectionClone->getSelect()
            ->joinLeft(
                ['rt' => $productCollectionClone->getTable('review_entity_summary')],
                "e.entity_id = rt.entity_pk_value AND rt.store_id = " . $this->_storeManager->getStore()->getId(),
                ['rating_summary']
            );

            $from = (int)$step*20;
            $to = 100;
            $productCollectionClone->getSelect()->where('rt.rating_summary <= '.$to);
            $productCollectionClone->getSelect()->where('rt.rating_summary >= '.$from);
            $count = $productCollectionClone->resetTotalRecords()->getSize();
            if ($count) {
                $this->itemDataBuilder->addItemData(
                    $label,
                    $step,
                    $count
                );
            }
        }
        return $this->itemDataBuilder->build();
    }
}
