<?php

namespace Playhf\OrderMultiply\Api\Data;


interface OrderInterface
{
    const ENTITY_ID = 'entity_id';
    const STORE_ID  = 'store_id';
    const INCREMENT_ID = 'increment_id';
    const DECIMAL_FACTOR = 'decimal_factor';
    const GRAND_TOTAL_MULTIPLIED = 'grand_total_multiplied';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Store Id
     *
     * @return int|null
     */
    public function getStoreId();

    /**
     * Get order increment id
     *
     * @return string|null
     */
    public function getIncrementId();

    /**
     * Get decimal factor
     *
     * @return string|null
     */
    public function getDecimalFactor();

    /**
     * Retrieves grand total multiplied on decimal factor
     *
     * @return string|null
     *
     */
    public function getGrandTotalMultiplied();

    /**
     * Set ID
     *
     * @param int $id
     * @return OrderInterface
     */
    public function setId($id);

    /**
     * Set Store Id
     *
     * @param int $storeId
     * @return OrderInterface
     */
    public function setStoreId($storeId);

    /**
     * Sets the increment ID for the order.
     *
     * @param string $incrementId
     * @return OrderInterface
     */
    public function setIncrementId($incrementId);

    /**
     * Sets the decimal factor for the total
     *
     * @param string $decimal
     * @return OrderInterface
     */
    public function setDecimalFactor($decimal);

    /**
     * Sets grant total multiplied on decimal factor
     *
     * @param string $total
     * @return OrderInterface
     */
    public function setGrandTotalMultiplied($total);
}