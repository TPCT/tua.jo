<?php

use yii\db\Migration;

class m250504_124619_add_amounts_to_donation_programs_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_programs_items', 'amount_jod', $this->float(2)->null()->defaultValue(0));
        $this->addColumn('donation_programs_items', 'amount_usd', $this->float(2)->null()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250504_124619_add_amounts_to_donation_programs_items cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250504_124619_add_amounts_to_donation_programs_items cannot be reverted.\n";

        return false;
    }
    */
}
