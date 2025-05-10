<?php

use yii\db\Migration;

class m250417_102439_add_has_amount_to_donation_programs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs}}', 'has_amount', $this->boolean()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250417_102439_add_has_amount_to_donation_programs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250417_102439_add_has_amount_to_donation_programs cannot be reverted.\n";

        return false;
    }
    */
}
