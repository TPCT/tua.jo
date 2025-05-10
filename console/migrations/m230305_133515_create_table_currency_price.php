<?php

use yii\db\Migration;

/**
 * Class m230305_133515_create_table_currency_price
 */
class m230305_133515_create_table_currency_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("currency_price",
        [
            "id" => $this->primaryKey(),
            'status' => $this->integer(1)->comment("0-pending 1-published")->defaultValue(0)->notNull(),
            'price' => $this->decimal(12,2)->notNull(),
            'published_at' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
            'revision' => $this->boolean()->defaultValue(0)->notNull(),
            'changed' => $this->boolean()->defaultValue(0)->notNull(),
            "reject_note" => $this->string(255)->null(),

        ]);


        // creates index for column `status`
        $this->createIndex(
            'idx-currency_price-status',
            'currency_price',
            'status'
        );
        // creates index for column `created_by`
        $this->createIndex(
            'idx-currency_price-created_by',
            'currency_price',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-currency_price-created_by',
            'currency_price',
            'created_by',
            'user',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-currency_price-updated_by',
            'currency_price',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-currency_price-updated_by',
            'currency_price',
            'updated_by',
            'user',
            'id',
            'RESTRICT',
            'CASCADE'
        );


        //crate lang table
        $this->createTable("currency_price_lang",[
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11),
            'language' => $this->string(6)->notNull(),
            'title' => $this->string(255)->notNull(),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-currency_price_lang-parent_id',
            'currency_price_lang',
            'parent_id'
        );

        // add foreign key for table `currency_price`
        $this->addForeignKey(
            'fk-currency_price_lang-parent_id',
            'currency_price_lang',
            'parent_id',
            'currency_price',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `language`
        $this->createIndex(
            'idx-currency_price_lang-language',
            'currency_price_lang',
            'language'
        );


        



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("currency_price_lang");
        $this->dropTable("currency_price");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230305_133515_create_table_currency_price cannot be reverted.\n";

        return false;
    }
    */
}
