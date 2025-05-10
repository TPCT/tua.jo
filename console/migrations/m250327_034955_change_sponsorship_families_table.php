<?php

use yii\db\Migration;

class m250327_034955_change_sponsorship_families_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%sponsorship_families}}', 'sponsorship_families_id', 'donation_type_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250327_034955_change_sponsorship_families_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250327_034955_change_sponsorship_families_table cannot be reverted.\n";

        return false;
    }
    */
}
