<?php

use yii\db\Migration;

class m250113_131931_update_size_of_content_at_interviews_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("interviews_lang","content","MEDIUMTEXT");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250113_131931_update_size_of_content_at_interviews_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250113_131931_update_size_of_content_at_interviews_lang cannot be reverted.\n";

        return false;
    }
    */
}
