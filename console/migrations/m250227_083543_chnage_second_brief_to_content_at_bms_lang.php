<?php

use yii\db\Migration;

class m250227_083543_chnage_second_brief_to_content_at_bms_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('bms_lang', 'second_brief', 'content');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250227_083543_chnage_second_brief_to_content_at_bms_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250227_083543_chnage_second_brief_to_content_at_bms_lang cannot be reverted.\n";

        return false;
    }
    */
}
