<?php

use yii\db\Migration;

class m250324_181612_add_currency_id_to_currency_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("currency_price","currency_id",$this->integer(11)->defaultValue(1)->after("id")->notNull());

        // creates index for column `investment_type_id`
        $this->createIndex(
            'idx-currency_price-currency_id',
            'currency_price',
            'currency_id'
        );

        // add foreign key for table `dropdown_list`
        $this->addForeignKey(
            'fk-currency_price-currency_id',
            'currency_price',
            'currency_id',
            'currency',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_181612_add_currency_id_to_currency_price_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_181612_add_currency_id_to_currency_price_table cannot be reverted.\n";

        return false;
    }
    */
}
