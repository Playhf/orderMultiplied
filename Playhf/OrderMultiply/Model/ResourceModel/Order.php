<?php

namespace Playhf\OrderMultiply\Model\ResourceModel;

use Playhf\OrderMultiply\Setup\InstallSchema;
use Playhf\OrderMultiply\Api\Data\OrderInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Order extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TABLE_NAME_MAIN, OrderInterface::ENTITY_ID);
    }
}