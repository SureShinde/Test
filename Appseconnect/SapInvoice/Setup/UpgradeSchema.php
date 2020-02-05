<?php
namespace Appseconnect\SapInvoice\Setup;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.3') < 0) {
            $setup->startSetup();
            $invoiceTable = 'sales_invoice';
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($invoiceTable),
                    'invoice_number',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' =>'Invoice Number'
                    ]
                );
            $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Customer Number'
                ]
            );
            $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'your_contact',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Your Contact'
                ]
            );
            $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'payment_term',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Payment Term'
                ]
            );
            $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'comment',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'comment'
                ]
            );

            $setup->endSetup();     
        }
        if (version_compare($context->getVersion(), '0.0.4') < 0) {
            $setup->startSetup();
            $invoiceTable = 'sales_invoice';
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($invoiceTable),
                    'posting_date',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' =>'posting date'
                    ]
                );

            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($invoiceTable),
                    'additional_charges',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' =>'additional charges'
                    ]
                );
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($invoiceTable),
                    'discount_charge',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' =>'discount charge'
                    ]
                );
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($invoiceTable),
                    'environmental_fees',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' =>'environmental fees'
                    ]
                );
        }
    }
}
