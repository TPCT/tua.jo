<?php

use yii\db\Migration;

class m250303_135323_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->defaultValue(null),
            'status' => $this->tinyInteger(1)->defaultValue(null),
            'weight' => $this->tinyInteger()->defaultValue(10),

            'rate' => $this->integer(),
            'is_default' => $this->tinyInteger()->defaultValue(0),

            'revision' => $this->integer()->notNull()->defaultValue(0),
            'changed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'reject_note' => $this->string(255)->defaultValue(null),
            'published_at' => $this->integer()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->integer()->defaultValue(null),
            'updated_by' => $this->integer()->defaultValue(null),
        ]);

        $this->createIndex('idx-currency-updated_by', 'currency', 'updated_by');
        $this->createIndex('idx-currency-weight_order', 'currency', 'weight');
   



        
        $this->addForeignKey(
            'fk-currency-created_by',
            'currency',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-currency-updated_by',
            'currency',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('currency_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'language' => $this->string(6)->defaultValue(null),
            'title' => $this->string(255)->defaultValue(null),

        ]);


        $this->createIndex('idx-currency_lang-parent_id', 'currency_lang', 'parent_id');
        $this->createIndex('idx-currency_lang-language', 'currency_lang', 'language');

        // Add foreign keys
        $this->addForeignKey(
            'fk-currency_lang-parent_id',
            'currency_lang',
            'parent_id',
            'currency',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250303_135323_create_currency_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250303_135323_create_currency_table cannot be reverted.\n";

        return false;
    }
    */
}
