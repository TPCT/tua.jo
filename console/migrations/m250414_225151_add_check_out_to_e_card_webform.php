<?php

use yii\db\Migration;

class m250414_225151_add_check_out_to_e_card_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('e_card_webform', 'checkout_id', $this->string()->notNull());
        $this->addColumn('e_card_webform', 'status', $this->integer()->defaultValue(0));
        $this->addColumn('e_card_webform', 'send_when_finished', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_225151_add_check_out_to_e_card_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_225151_add_check_out_to_e_card_webform cannot be reverted.\n";

        return false;
    }
    */
}
