<?php

namespace Playhf\OrderMultiply\Model;

use Playhf\OrderMultiply\Api\Data\OrderInterface;
use Magento\Framework\Model\AbstractModel;

class Order extends AbstractModel implements OrderInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Order::class);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritdoc
     */
    public function getIncrementId()
    {
        return $this->getData(self::INCREMENT_ID);
    }

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function getDecimalFactor()
    {
        return $this->getData(self::DECIMAL_FACTOR);
    }

    /**
     * @inheritdoc
     */
    public function getGrandTotalMultiplied()
    {
        return $this->getData(self::GRAND_TOTAL_MULTIPLIED);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function setIncrementId($incrementId)
    {
        return $this->setData(self::INCREMENT_ID, $incrementId);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * @inheritdoc
     */
    public function setDecimalFactor($decimal)
    {
        return $this->setData(self::DECIMAL_FACTOR, $decimal);
    }

    /**
     * @inheritdoc
     */
    public function setGrandTotalMultiplied($total)
    {
        return $this->setData(self::GRAND_TOTAL_MULTIPLIED, $total);
    }
}