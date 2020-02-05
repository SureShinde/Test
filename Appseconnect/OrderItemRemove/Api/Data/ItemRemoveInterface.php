<?php

namespace Appseconnect\OrderItemRemove\Api\Data;

/**
 * Interface for edit  order item interface
 * @api
 */

interface ItemRemoveInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ORDER_ID = 'order_id';
    const ENTITY_ID = 'entity_id';
    const SUB_TOTAL = 'sub_total';
    const GRAND_TOTAL = 'grand_total';
    const SHIPPING_AMOUNT = 'shipping_amount';
    const SHIPPING_INCL_TAX = 'shipping_incl_tax';
    const SHIPPING_TAX_AMOUNT ='shipping_tax_amount';
    const BASE_GRAND_TOTAL = 'base_grand_total';
    const BASE_SHIPPING_AMOUNT ='base_shipping_amount';
    const BASE_SUBTOTAL = 'base_subtotal';
    const BASE_SHIPPING_TAX_AMOUNT = 'base_shipping_tax_amount';
    const BASE_SUBTOTAL_INCL_TAX ='base_subtotal_incl_tax';
    const BASE_TAX_AMOUNT = 'tax_amount';
    CONST BASE_TOTAL_DUE = 'base_total_due';
    const ITEMS ='items';

    /**
     * Get the order id.
     *
     * @return int|null Order Id.
     */
    public function getOrderId();

    /**
     * Get the entity id.
     *
     * @return int|null Order Id.
     */
    public function getEntityId();
    /**
     * @return mixed
     */
    public function getSubTotal();

    /**
     * @return mixed
     */
    public function getGrandTotal();

    /**
     * @return mixed
     */
    public function getShippingAmount();
    /**
     * @return mixed
     */
    public function getShippingInclTax();
    /**
     * @return mixed
     */
    public function getShippingTaxAmount();
    /**
     * @return mixed
     */
    public function getBaseGrandTotal();
    /**
     * @return mixed
     */
    public function getBaseShippingAmount();
    /**
     * @return mixed
     */
    public function getBaseSubtotal();
    /**
     * @return mixed
     */
    public function getBaseShippingTaxAmount();
    /**
     * @return mixed
     */
    public function getBaseSubtotalInclTax();
    /**
     * @return mixed
     */
    public function getBaseTaxAmount();

    /**
     * @return mixed
     */
    public function getBaseTotalDue();

    /**
     * Get the items.
     * @params \Appseconnect\OrderItemRemove\Api\Data\ItemsInterface[] $items
     * @return \Appseconnect\OrderItemRemove\Api\Data\ItemsInterface[]
     */
    public function getItems();


    /**
     * Set IOrder ID
     *
     * @param $order_id
     *
     * @return $this
     */
    public function setOrderId($order_id);

    /**
     * Set Entity ID
     *
     * @param $entity_id
     *
     * @return $this
     */
    public function setEntityId($entity_id);

    /**
     * @param $subtotal
     * @return mixed
     */
    public function setSubTotal($sub_total);

    /**
     * @param $grand_total
     * @return mixed
     */
    public function setGrandTotal($grand_total);

    /**
     * @param $shippingAmount
     * @return mixed
     */
    public function setShippingAmount($shippingAmount);

    /**
     * @param $shipping_incl_tax
     * @return mixed
     */
    public function setShippingInclTax($shipping_incl_tax);

    /**
     * @param $shipping_tax_amount
     * @return mixed
     */
    public function setShippingTaxAmount($shipping_tax_amount);

    /**
     * @param $base_grand_total
     * @return mixed
     */
    public function setBaseGrandTotal($base_grand_total);

    /**
     * @param $base_shipping_amount
     * @return mixed
     */
    public function setBaseShippingAmount($base_shipping_amount);

    /**
     * @param $base_subtotal
     * @return mixed
     */
    public function setBaseSubtotal($base_subtotal);

    /**
     * @param $base_shipping_tax_amount
     * @return mixed
     */
    public function setBaseShippingTaxAmount($base_shipping_tax_amount);

    /**
     * @param $base_subtotal_incl_tax
     * @return mixed
     */
    public function setBaseSubtotalInclTax($base_subtotal_incl_tax);

    /**
     * @param $base_tax_amount
     * @return mixed
     */
    public function setBaseTaxAmount($base_tax_amount);

    /**
     * @param $base_subtotal_due
     * @return mixed
     */
    public function setBaseTotalDue($base_subtotal_due);

    /**
     * Set the items.
     *
     * @param \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface[] $items
     * @return void
     */
    public function setItems(array $items);

}
