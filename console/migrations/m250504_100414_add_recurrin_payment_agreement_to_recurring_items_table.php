<?php

use yii\db\Migration;

class m250504_100414_add_recurrin_payment_agreement_to_recurring_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%recurring_items}}', 'recurring_payment_agreement', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%recurring_items}}', 'recurring_payment_agreement_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250504_100414_add_recurrin_payment_agreement_to_recurring_items_table cannot be reverted.\n";

        return false;
    }
    */
}
