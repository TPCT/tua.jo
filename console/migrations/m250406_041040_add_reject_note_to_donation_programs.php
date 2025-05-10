<?php

use yii\db\Migration;

class m250406_041040_add_reject_note_to_donation_programs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs}}', 'reject_note', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_041040_add_reject_note_to_donation_programs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_041040_add_reject_note_to_donation_programs cannot be reverted.\n";

        return false;
    }
    */
}
