<?php

use yii\db\Migration;

class m250417_102020_add_missing_to_donation_programs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_programs', 'is_recurring', $this->boolean()->defaultValue(false));
        $this->addColumn('donation_programs', 'has_related_stories_slider', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250417_102020_add_missing_to_donation_programs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250417_102020_add_missing_to_donation_programs cannot be reverted.\n";

        return false;
    }
    */
}
