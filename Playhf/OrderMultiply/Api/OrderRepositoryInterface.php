<?php

namespace Playhf\OrderMultiply\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderRepositoryInterface
{
    /**
     * Save order.
     *
     * @param Data\OrderInterface $order
     * @return Data\OrderInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(Data\OrderInterface $order);

    /**
     * Retrieve empty order model
     *
     * @return Data\OrderInterface
     */
    public function get();

    /**
     * Retrieve order data by id
     *
     * @param int $id
     * @return Data\OrderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * Retrieve orders matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return Data\OrderSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete order data.
     *
     * @param Data\OrderInterface $order
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(Data\OrderInterface $order);

    /**
     * @param string $incrementId
     * @return Data\OrderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIncrementId($incrementId);

    /**
     * Delete order by ID.
     *
     * @param int $incrementId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteByIncrementId($incrementId);
}