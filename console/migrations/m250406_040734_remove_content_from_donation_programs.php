<?php

use yii\db\Migration;

class m250406_040734_remove_content_from_donation_programs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%donation_programs_lang}}', 'content');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_040734_remove_content_from_donation_programs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_040734_remove_content_from_donation_programs cannot be reverted.\n";

        return false;
    }
    */
}
