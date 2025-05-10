<?php

use yii\db\Migration;

class m250407_063145_change_donation_type_id_to_be_nullable_in_donation_programs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%donation_programs}}', 'donation_type_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250407_063145_change_donation_type_id_to_be_nullable_in_donation_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_063145_change_donation_type_id_to_be_nullable_in_donation_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
