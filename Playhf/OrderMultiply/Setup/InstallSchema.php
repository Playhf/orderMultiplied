<?php

namespace Playhf\OrderMultiply\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Playhf\OrderMultiply\Api\Data\OrderInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Table name
     */
    const TABLE_NAME_MAIN  = 'sales_order_multiplied';

    /**
     * @inheritdoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();

        $table = $connection->newTable(
            $setup->getTable(static::TABLE_NAME_MAIN)
        )->addColumn(
            OrderInterface::ENTITY_ID,
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        )->addColumn(
            OrderInterface::STORE_ID,
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Store Id'
        )->addColumn(
            OrderInterface::INCREMENT_ID,
            Table::TYPE_TEXT,
            32,
            [],
            'Order Increment Id'
        )->addColumn(
            OrderInterface::GRAND_TOTAL_MULTIPLIED,
            Table::TYPE_DECIMAL,
            '12,4',
            ['unsigned' => true, 'nullable' => false],
            'Total paid sum multiplied'
        )->addColumn(
            OrderInterface::DECIMAL_FACTOR,
            Table::TYPE_DECIMAL,
            '12,2',
            ['unsigned' => true, 'nullable' => false],
            'Decimal factor'
        )->addIndex(
            $setup->getIdxName(static::TABLE_NAME_MAIN, [OrderInterface::INCREMENT_ID]),
            [OrderInterface::INCREMENT_ID]
        )->addForeignKey(
            $setup->getFkName(static::TABLE_NAME_MAIN, OrderInterface::INCREMENT_ID, 'sales_order', OrderInterface::INCREMENT_ID),
            OrderInterface::INCREMENT_ID,
            $setup->getTable('sales_order'),
            OrderInterface::INCREMENT_ID,
            Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(static::TABLE_NAME_MAIN, OrderInterface::STORE_ID, 'store', OrderInterface::STORE_ID),
            OrderInterface::STORE_ID,
            $setup->getTable('store'),
            OrderInterface::STORE_ID,
            Table::ACTION_CASCADE
        )->setComment(
            'Order Multiplied Table'
        );

        $connection->createTable($table);

        $setup->endSetup();
    }
}