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
 * @package Xvrmallafre\StoreReviews\Setup
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
        $reviewsTable = 'pilot';

        if (!$installer->tableExists($reviewsTable)) {
            $connection = $installer->getConnection();

            try {
                $table = $connection->newTable(
                    $installer->getTable($reviewsTable)
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
                        'created_at',
                        Table::TYPE_DATETIME,
                        null,
                        ['default' => new Zend_Db_Expr('CURRENT_TIMESTAMP')]
                    );
                $installer->getConnection()->createTable($table);

                $installer->getConnection()->addIndex(
                    $installer->getTable($reviewsTable),
                    $installer->getIdxName(
                        $installer->getTable($reviewsTable),
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
