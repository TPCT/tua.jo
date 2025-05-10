<?php

use yii\db\Migration;

class m250428_124715_make_by_phone_by_email_prefer_not_to_communicate_default_zero extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('complaint_webform', 'by_phone', $this->tinyInteger()->defaultValue(0));
        $this->alterColumn('complaint_webform', 'by_email', $this->tinyInteger()->defaultValue(0));
        $this->alterColumn('complaint_webform', 'prefer_not_to_communicate', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250428_124715_make_by_phone_by_email_prefer_not_to_communicate_default_zero cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250428_124715_make_by_phone_by_email_prefer_not_to_communicate_default_zero cannot be reverted.\n";

        return false;
    }
    */
}
