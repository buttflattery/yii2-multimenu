<?php
//@codingStandardsIgnoreStart

use yii\db\Migration;

/**
 * Class m190714_235744_menu_table
 */
class m190714_235744_menu_table extends Migration
{
    //@codingStandardsIgnoreEnd

    /**
     * @var mixed
     */
    public $tableOptions;

    /**
     * @var string
     */
    private $_table = "{{%menu}}";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        switch ($this->db->driverName) {
            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                break;
            case 'pgsql':
                $this->tableOptions = null;
                break;
            case 'dblib':
            case 'mssql':
            case 'sqlsrv':
                $this->tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            $this->_table,
            [
                'id' => $this->primaryKey(),
                'label' => $this->string(50)->notNull(),
                'link' => $this->text()->null(),
                'parent_id' => $this->integer(11)->null()
            ],
            $this->tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->_table);
    }

}
