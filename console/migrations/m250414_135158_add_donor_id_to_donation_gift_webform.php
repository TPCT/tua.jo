<?php

use yii\db\Migration;

class m250414_135158_add_donor_id_to_donation_gift_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{donation_gift_webform}}', 'donor_id', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_135158_add_donor_id_to_donation_gift_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_135158_add_donor_id_to_donation_gift_webform cannot be reverted.\n";

        return false;
    }
    */
}
