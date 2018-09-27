<?php

namespace Playhf\OrderMultiply\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface OrderSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get orders list.
     *
     * @return \Playhf\OrderMultiply\Api\Data\OrderInterface[]
     */
    public function getItems();

    /**
     * Set orders list.
     *
     * @param \Playhf\OrderMultiply\Api\Data\OrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}