<?php

use yii\db\Migration;

class m250504_095934_add_payment_agreement_to_cards_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cards}}', 'recurring_payment_agreement', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250504_095934_add_payment_agreement_to_cards_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250504_095934_add_payment_agreement_to_cards_table cannot be reverted.\n";

        return false;
    }
    */
}
