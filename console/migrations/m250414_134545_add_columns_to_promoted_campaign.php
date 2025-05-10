<?php

use yii\db\Migration;

class m250414_134545_add_columns_to_promoted_campaign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('promoted_campaigns', 'promoted_to_front', $this->tinyInteger(3)->defaultValue(0));

        $this->addColumn('promoted_campaigns', 'campaign_id', $this->integer()->null());
        $this->addColumn('promoted_campaigns', 'donation_type_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_134545_add_columns_to_promoted_campaign cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_134545_add_columns_to_promoted_campaign cannot be reverted.\n";

        return false;
    }
    */
}
