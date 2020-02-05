<?php
namespace Appseconnect\OrderItemRemove\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;
/**
 * Class ItemRemoveD Data
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class ItemRemoveData extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface
{

    /**
     * Get Order Id
     *
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Get entity Id
     *
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * @return mixed|null
     */
    public function getSubTotal(){

        return $this->_get(self::SUB_TOTAL);
    }

    /**
     * @return mixed|null
     */
    public function getGrandTotal(){
        return $this->_get(self::GRAND_TOTAL);

    }

    /**
     * @return mixed|null
     */
    public function getShippingAmount(){
        return $this->_get(self::SHIPPING_AMOUNT);
    }

    /**
     * @return mixed|null
     */
    public function getShippingInclTax(){
        return $this->_get(self::SHIPPING_INCL_TAX);
    }

    /**
     * @return mixed|null
     */
    public function getShippingTaxAmount(){
        return $this->_get(self::SHIPPING_TAX_AMOUNT);
    }

    /**
     * @return mixed|null
     */
    public function getBaseGrandTotal(){
        return $this->_get(self::BASE_GRAND_TOTAL);
    }

    /**
     * @return mixed|null
     */
    public function getBaseShippingAmount(){
        return $this->_get(self::BASE_SHIPPING_AMOUNT);
    }

    /**
     * @return mixed|null
     */
    public function getBaseSubtotal(){
        return $this->_get(self::BASE_SUBTOTAL);
    }

    /**
     * @return mixed|null
     */
    public function getBaseShippingTaxAmount(){
        return $this->_get(self::BASE_SHIPPING_TAX_AMOUNT);
    }

    /**
     * @return mixed|null
     */
    public function getBaseSubtotalInclTax(){
        return $this->_get(self::BASE_SUBTOTAL_INCL_TAX);
    }

    /**
     * @return mixed|null
     */
    public function getBaseTaxAmount(){
        return $this->_get(self::BASE_TAX_AMOUNT);
    }

    /**
     * @return mixed|null
     */
    public function getBaseTotalDue(){
        return $this->_get(self::BASE_TOTAL_DUE);
    }


    /**
     * @return \Appseconnect\OrderItemRemove\Api\Data\ItemsInterface[]|mixed|null
     */

    public function getItems()
    {
        return $this->_get(self::ITEMS);
    }

    /**
     * @param $order_id
     * @return \Appseconnect\OrderItemRemove\Api\Data\ItemRemoveInterface|ItemRemoveData
     */
    public function setOrderId($order_id)
    {
        return $this->setData(self::ORDER_ID, $order_id);
    }

    /**
     * @param $entity_id
     * @return ItemRemoveData
     */
    public function setEntityId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }
    /**
     * @param $subtotal
     * @return ItemRemoveData
     */
    public function setSubTotal($sub_total){
        return $this->setData(self::SUB_TOTAL, $sub_total);

    }

    /**
     * @param $grand_total
     * @return ItemRemoveData
     */
    public function setGrandTotal($grand_total){
        return $this->setData(self::GRAND_TOTAL, $grand_total);

    }

    /**
     * @param $shipping_amount
     * @return ItemRemoveData
     */
    public function setShippingAmount($shipping_amount){
        return $this->setData(self::SHIPPING_AMOUNT, $shipping_amount);

    }

    /**
     * @param $shipping_incl_tax
     * @return ItemRemoveData
     */
    public function setShippingInclTax($shipping_incl_tax){
        return $this->setData(self::SHIPPING_INCL_TAX, $shipping_incl_tax);
    }

    /**
     * @param $shipping_tax_amount
     * @return ItemRemoveData
     */
    public function setShippingTaxAmount($shipping_tax_amount){
        return $this->setData(self::SHIPPING_TAX_AMOUNT, $shipping_tax_amount);
    }

    /**
     * @param $base_grand_total
     * @return ItemRemoveData
     */
    public function setBaseGrandTotal($base_grand_total){
        return $this->setData(self::BASE_GRAND_TOTAL, $base_grand_total);
    }

    /**
     * @param $base_shipping_amount
     * @return ItemRemoveData
     */
    public function setBaseShippingAmount($base_shipping_amount){
        return $this->setData(self::BASE_SHIPPING_AMOUNT, $base_shipping_amount);
    }

    /**
     * @param $base_subtotal
     * @return ItemRemoveData
     */
    public function setBaseSubtotal($base_subtotal){
        return $this->setData(self::BASE_SUBTOTAL, $base_subtotal);
    }

    /**
     * @param $base_shipping_tax_amount
     * @return ItemRemoveData
     */
    public function setBaseShippingTaxAmount($base_shipping_tax_amount){
        return $this->setData(self::BASE_SHIPPING_TAX_AMOUNT, $base_shipping_tax_amount);
    }

    /**
     * @param $base_subtotal_incl_tax
     * @return ItemRemoveData
     */
    public function setBaseSubtotalInclTax($base_subtotal_incl_tax){
        return $this->setData(self::BASE_SUBTOTAL_INCL_TAX, $base_subtotal_incl_tax);
    }

    /**
     * @param $base_tax_amount
     * @return ItemRemoveData
     */
    public function setBaseTaxAmount($base_tax_amount){
        return $this->setData(self::BASE_TAX_AMOUNT, $base_tax_amount);
    }

    /**
     * @param $base_total_due
     * @return ItemRemoveData
     */
    public function setBaseTotalDue($base_total_due){
        return $this->setData(self::BASE_TOTAL_DUE, $base_total_due);
    }


    /**
     * @param array $items
     * @return ItemRemoveData|void
     */
    public function setItems(array $items)
    {
        return $this->setData(self::ITEMS, $items);
    }

}
