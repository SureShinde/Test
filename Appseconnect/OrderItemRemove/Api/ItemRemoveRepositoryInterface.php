<?php
namespace Appseconnect\OrderItemRemove\Api;

interface ItemRemoveRepositoryInterface
{

    /**
     * Update custom Api.
     *
     * @param \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface $editOrderItem
     * @return \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function update(
        \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface $editOrderItem
    );
}
