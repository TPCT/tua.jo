<?php

use yii\db\Migration;

class m250324_195900_add_status_to_secondary_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%secondary_users}}', 'status', $this->tinyInteger(1)->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_195900_add_status_to_secondary_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_195900_add_status_to_secondary_users_table cannot be reverted.\n";

        return false;
    }
    */
}
