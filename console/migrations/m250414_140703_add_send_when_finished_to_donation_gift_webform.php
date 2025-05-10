<?php

use yii\db\Migration;

class m250414_140703_add_send_when_finished_to_donation_gift_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_gift_webform', 'send_when_finished', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_140703_add_send_when_finished_to_donation_gift_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_140703_add_send_when_finished_to_donation_gift_webform cannot be reverted.\n";

        return false;
    }
    */
}
