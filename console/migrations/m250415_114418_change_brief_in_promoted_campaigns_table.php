<?php

use yii\db\Migration;

class m250415_114418_change_brief_in_promoted_campaigns_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('promoted_campaigns_lang', 'brief', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250415_114418_change_brief_in_promoted_campaigns_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_114418_change_brief_in_promoted_campaigns_table cannot be reverted.\n";

        return false;
    }
    */
}
