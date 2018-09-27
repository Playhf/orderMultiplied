<?php

namespace Playhf\OrderMultiply\Model;

use Playhf\OrderMultiply\Api\Data;
use Playhf\OrderMultiply\Model\ResourceModel\Order;
use Playhf\OrderMultiply\Api\OrderRepositoryInterface;
use Playhf\OrderMultiply\Api\Data\OrderInterfaceFactory;
use Playhf\OrderMultiply\Api\Data\OrderSearchResultInterfaceFactory;
use Playhf\OrderMultiply\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use \Magento\Framework\Exception\CouldNotDeleteException;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var Order
     */
    private $resource;

    /**
     * @var OrderInterfaceFactory
     */
    private $orderFactory;

    /**
     * @var OrderSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * OrderRepository constructor.
     * @param Order $resource
     * @param OrderInterfaceFactory $orderFactory
     * @param OrderSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        Order $resource,
        OrderInterfaceFactory $orderFactory,
        OrderSearchResultInterfaceFactory $searchResultFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->resource = $resource;
        $this->orderFactory = $orderFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritdoc
     */
    public function save(Data\OrderInterface $order)
    {
        try {
            $this->resource->save($order);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not save the order: %1', $e->getMessage()),
                $e
            );
        }
        return $order;
    }

    /**
     * @inheritdoc
     */
    public function get()
    {
        return $this->orderFactory->create();
    }

    /**
     * @inheritdoc
     */
    public function getByIncrementId($incrementId)
    {
        $order = $this->get();
        $order->load($incrementId, Data\OrderInterface::INCREMENT_ID);

        if (!$order->getId()) {
            throw new NoSuchEntityException(__('Order with increment id "%1" doesn\'t exists', $incrementId));
        }

        return $order;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Playhf\OrderMultiply\Model\ResourceModel\Order\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\OrderSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function getById($id)
    {
        $order = $this->get();
        $order->load($id);

        if (!$order->getId()) {
            throw new NoSuchEntityException(__('Order with id "%1" doesn\'t exists', $id));
        }

        return $order;
    }

    /**
     * @inheritdoc
     */
    public function delete(Data\OrderInterface $order)
    {
        try {
            $this->resource->delete($order);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(
                __("Couldn't delete the order %1"),
                $e->getMessage()
            );
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteByIncrementId($incrementId)
    {
        return $this->delete($this->getByIncrementId($incrementId));
    }
}