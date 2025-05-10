<?php

use yii\db\Migration;

class m250327_035245_add_sponsored_to_sponsorship_families_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sponsorship_families}}', 'sponsored', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250327_035245_add_sponsored_to_sponsorship_families_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250327_035245_add_sponsored_to_sponsorship_families_table cannot be reverted.\n";

        return false;
    }
    */
}
