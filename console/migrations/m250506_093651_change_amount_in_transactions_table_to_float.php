<?php

use yii\db\Migration;

class m250506_093651_change_amount_in_transactions_table_to_float extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%transactions}}', 'amount', $this->decimal(10,2)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250506_093651_change_amount_in_transactions_table_to_float cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250506_093651_change_amount_in_transactions_table_to_float cannot be reverted.\n";

        return false;
    }
    */
}
