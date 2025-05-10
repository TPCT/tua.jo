<?php

use yii\db\Migration;

class m250324_180930_add_national_currency__to_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("currency","national_currency",$this->integer(1)->defaultValue(0)->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_180930_add_national_currency__to_currency_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_180930_add_national_currency__to_currency_table cannot be reverted.\n";

        return false;
    }
    */
}
