<?php

use yii\db\Migration;

class m250324_183735_add_guid_to_secondary_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%secondary_users}}', 'guid', $this->string()->notNull()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_183735_add_guid_to_secondary_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_183735_add_guid_to_secondary_users_table cannot be reverted.\n";

        return false;
    }
    */
}
