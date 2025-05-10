<?php

use yii\db\Migration;

class m250324_195404_drop_unique_index_from_email_in_secondary_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('email', '{{%secondary_users}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_195404_drop_unique_index_from_email_in_secondary_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_195404_drop_unique_index_from_email_in_secondary_users_table cannot be reverted.\n";

        return false;
    }
    */
}
