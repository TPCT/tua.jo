<?php

use yii\db\Migration;

class m250414_154735_add_checkout_id_and_status_to_donation_gift_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_gift_webform', 'checkout_id', $this->string()->notNull());
        $this->addColumn('donation_gift_webform', 'status', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_154735_add_checkout_id_and_status_to_donation_gift_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_154735_add_checkout_id_and_status_to_donation_gift_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
