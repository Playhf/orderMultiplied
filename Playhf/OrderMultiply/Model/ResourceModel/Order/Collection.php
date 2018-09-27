<?php

namespace Playhf\OrderMultiply\Model\ResourceModel\Order;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(\Playhf\OrderMultiply\Model\Order::class,
            \Playhf\OrderMultiply\Model\ResourceModel\Order::class
        );
    }
}