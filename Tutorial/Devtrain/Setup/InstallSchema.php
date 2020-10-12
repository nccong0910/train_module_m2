<?php
 
namespace Tutorial\Devtrain\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
 
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
 
        $tableName = $setup->getTable('construct');
        // Kiểm tra xem tên bảng đã tồn tại hay chưa, nếu chưa thì tạo bảng
        if ($setup->getConnection()->isTableExists($tableName) != true) {
            $table = $setup->getConnection()->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false, 'default' => ''
                    ],
                    'Title'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Description'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Image'
                )
                ->addColumn(
                  'status',
                  Table::TYPE_INTEGER,
                  null,
                  [
                      'nullable' => false, 'default' => '0'
                  ],
                  'Status'
              )
              ->addColumn(
                  'create_at',
                  Table::TYPE_DATETIME,
                  null,
                  [
                      'nullable' => false
                  ],
                  'Create_at'
              )
              ->addColumn(
                'update_at',
                Table::TYPE_DATETIME,
                null,
                [
                    'nullable' => false
                ],
                'Update_at'
            )
                // ->setComment('Magetop Hello')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $setup->getConnection()->createTable($table);
        }
 
        $setup->endSetup();
    }
}