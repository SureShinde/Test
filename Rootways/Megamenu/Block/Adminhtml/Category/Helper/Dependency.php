<?php
namespace Rootways\Megamenu\Block\Adminhtml\Category\Helper;

class Dependency extends \Magento\Framework\Data\Form\Element\Select
{

    /**
     * Retrieve Element HTML fragment
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = parent::getElementHtml();
        $html .= ' <label for="vish" class="normal">' . __('Use Config Settings Vish') . '</label>';
        return $html;
    }
}
