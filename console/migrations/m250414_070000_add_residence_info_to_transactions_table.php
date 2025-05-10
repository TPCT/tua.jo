<?php

use yii\db\Migration;

class m250414_070000_add_residence_info_to_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->addColumn('{{%transactions}}', 'nationality', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_070000_add_residence_info_to_transactions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_070000_add_residence_info_to_transactions_table cannot be reverted.\n";

        return false;
    }
    */
}
