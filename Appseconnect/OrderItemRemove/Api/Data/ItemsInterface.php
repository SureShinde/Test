<?php

namespace Appseconnect\OrderItemRemove\Api\Data;

use Appseconnect\OrderItemRemove\Model\Data\ItemsData;

/**
 * Interface for edit  order item interface
 * @api
 */

interface ItemsInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */

    const SKU = 'sku';
    const ITEM_ID = 'item_id';
    const QTY_ORDERED = 'qty_ordered';
    const PRICE = 'price';
    const BASE_ORIGINAL_PRICE = 'base_original_price';
    const BASE_PRICE_INCL_TAX = 'base_price_incl_tax';
    const ROW_TOTAL = 'row_total';
    const BASE_PRICE = 'base_price';
    const TAX_PERCENT = 'tax_percent';
    const TAX_AMOUNT = 'tax_amount';


    /**
     * @return mixed
     */
    public function getItemId();

    /**
     * @return mixed
     */
    public function getPrice();

    /**
     * @return mixed
     */
    public function getQtyOrdered();

    /**
     * Get the order item Sku.
     *
     * @return string|null Item sku.
     */
    public function getSku();

    /**
     * @return mixed
     */
    public function getBaseOriginalPrice();

    /**
     * @return mixed
     */
    public function getBasePriceInclTax();

    /**
     * @return mixed
     */
    public function getRowTotal();

    /**
     * @return mixed
     */
    public function getBasePrice();

    /**
     * @return mixed
     */
    public function getTaxPercent();

    /**
     * @return mixed
     */
    public function  getTaxAmount();

    /**
     * Set Item Id
     *
     * @param $item_id
     *
     * @return $this
     */
    public function setItemId($item_id);

    /**
     * @param $price
     * @return mixed
     */
    public function setPrice($price);

    /**
     * @param $qty_ordered
     * @return mixed
     */
    public function setQtyOrdered($qty_ordered);


    /**
     * Set Item Sku
     *
     * @param $sku
     *
     * @return $this
     */
    public function setSku($sku);

    /**
     * @param $base_original_price
     * @return mixed
     */
    public function setBaseOriginalPrice($base_original_price);

    /**
     * @param $base_price_incl_tax
     * @return mixed
     */
    public function  setBasePriceInclTax($base_price_incl_tax);

    /**
     * @param $row_total
     * @return mixed
     */
    public function setRowTotal($row_total);

    /**
     * @param $base_price
     * @return mixed
     */
    public function setBasePrice($base_price);

    /**
     * @param $tax_percent
     * @return mixed
     */
    public function setTaxPercent($tax_percent);

    /**
     * @param $tax_amount
     * @return mixed
     */
    public function setTaxAmount($tax_amount);

    
}
