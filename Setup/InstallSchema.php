<?php

namespace Xvrmallafre\StarshipPilots\Setup;

use Exception;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Psr\Log\LoggerInterface;
use Zend_Db_Expr;

/**
 * Class InstallSchema
 *
 * @package Xvrmallafre\StarshipPilots\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /** @var LoggerInterface $logger */
    protected $logger;

    /**
     * InstallSchema constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup->startSetup();
        $pilotsTable = 'pilot';

        if (!$installer->tableExists($pilotsTable)) {
            $connection = $installer->getConnection();

            try {
                $table = $connection->newTable(
                    $installer->getTable($pilotsTable)
                )
                    ->addColumn(
                        'pilot_id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'Table identifier'
                    )
                    ->addColumn(
                        'pim_id',
                        Table::TYPE_BIGINT,
                        20,
                        [
                            'nullable' => false,
                            'unique' => true,
                        ],
                        'Comment done by client'
                    )
                    ->addColumn(
                        'name',
                        Table::TYPE_TEXT,
                        120,
                        null,
                        'Pilot name'
                    )
                    ->addColumn(
                        'gender',
                        Table::TYPE_TEXT,
                        32,
                        null,
                        'Pilot gender'
                    )
                    ->addColumn(
                        'created_at',
                        Table::TYPE_DATETIME,
                        null,
                        ['default' => new Zend_Db_Expr('CURRENT_TIMESTAMP')]
                    );
                $installer->getConnection()->createTable($table);

                $installer->getConnection()->addIndex(
                    $installer->getTable($pilotsTable),
                    $installer->getIdxName(
                        $installer->getTable($pilotsTable),
                        ['pilot_id'],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['pilot_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                );
            } catch (Exception $e) {
                $this->logger->error('InstallSchema Xvrmallafre_StarshipPilots: ' . $e->getMessage());
            }
        }

        $installer->endSetup();
    }
}
