<?php

use yii\db\Migration;

class m250416_100311_add_promote_to_payment_page_to_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_programs', 'promote_to_payment_page', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250416_100311_add_promote_to_payment_page_to_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250416_100311_add_promote_to_payment_page_to_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
