<?php
namespace Appseconnect\OrderItemRemove\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;
/**
 * Class ItemRemoveD Data
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class ItemsData extends \Magento\Framework\Api\AbstractExtensibleObject implements \Appseconnect\OrderItemRemove\Api\Data\ItemsInterface
{



    /**
     * @return mixed|null
     */
    public function getItemId()
    {
        return $this->_get(self::ITEM_ID);
    }

    /**
     * @return mixed|null
     */
    public function getPrice()
    {
        return $this->_get(self::PRICE);
    }


    /**
     * @return mixed|null
     */
    public function getQtyOrdered()
    {
        return $this->_get(self::QTY_ORDERED);
    }

    /**
     * @return mixed|string|null
     */
    public function getSku()
    {
        return $this->_get(self::SKU);
    }

    /**
     * @return mixed|null
     */
    public function getBaseOriginalPrice(){
        return  $this->_get(self::BASE_ORIGINAL_PRICE);

    }

    /**
     * @return mixed|null
     */
    public function getBasePriceInclTax(){
        return $this->_get(self::BASE_PRICE_INCL_TAX);

    }

    /**
     * @return mixed|null
     */
    public function getRowTotal(){
        return $this->_get(self::ROW_TOTAL);
    }

    /**
     * @return mixed|null
     */
    public function getBasePrice(){
        return $this->_get(self::BASE_PRICE);
    }


    /**
     * @return mixed|null
     */
    public function getTaxPercent(){
        return $this->_get(self::TAX_PERCENT);
    }


    /**
     * @return mixed|null
     */
    public function getTaxAmount(){
        return $this->_get(self::TAX_AMOUNT);

    }


    /**
     * @param $item_id
     * @return ItemsData
     */
    public function setItemId($item_id)
    {
        return $this->setData(self::ITEM_ID,$item_id);
    }
    
    /**
     * @param $price
     * @return ItemsData
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE,$price);
    }

    /**
     * @param $qty_ordered
     * @return ItemsData
     */

    public function setQtyOrdered($qty_ordered)
    {
        return $this->setData(self::QTY_ORDERED,$qty_ordered);
    }

    /**
     * @param $sku
     * @return \Appseconnect\OrderItemRemove\Api\Data\ItemsInterface|ItemsData
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }


    /**
     * @param $base_original_price
     * @return ItemsData
     */
    public function setBaseOriginalPrice($base_original_price){
        return  $this->setData(self::BASE_ORIGINAL_PRICE,$base_original_price);

    }

    /**
     * @param $base_price_incl_tax
     * @return ItemsData
     */
    public function setBasePriceInclTax($base_price_incl_tax){
        return $this->setData(self::BASE_PRICE_INCL_TAX,$base_price_incl_tax);

    }


    /**
     * @param $row_total
     * @return ItemsData
     */
    public function setRowTotal($row_total){
        return $this->setData(self::ROW_TOTAL,$row_total);
    }

    /**
     * @param $base_price
     * @return ItemsData
     */
    public function setBasePrice($base_price){
        return $this->setData(self::BASE_PRICE,$base_price);
    }


    /**
     * @param $tax_percent
     * @return ItemsData
     */
    public function setTaxPercent($tax_percent){
        return $this->setData(self::TAX_PERCENT,$tax_percent);
    }

    /**
     * @param $tax_amount
     * @return ItemsData
     */
    public function setTaxAmount($tax_amount){
        return $this->setData(self::TAX_AMOUNT,$tax_amount);

    }

}


//"price": "563.500000",
//"qty_ordered": "1.000000",
//"sku": "AC-ARCHITECT110",
//"base_original_price": "563.500000",
//"base_price_incl_tax": "563.500000",
//"item_id": "1042",
//"name": "AudioControl - 2 Ch. X 240 W/ch into 2 Ohms (8 speakers), Signal present LED's",
//"row_total": "563.500000",
//"base_price": "563.500000",
//"tax_percent": "0.000000",
//"tax_amount": "0.000000"