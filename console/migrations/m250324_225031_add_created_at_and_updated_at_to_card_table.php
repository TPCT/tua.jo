<?php

use yii\db\Migration;

class m250324_225031_add_created_at_and_updated_at_to_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%cards}}", 'created_at', $this->integer());
        $this->addColumn("{{%cards}}", 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250324_225031_add_created_at_and_updated_at_to_card_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250324_225031_add_created_at_and_updated_at_to_card_table cannot be reverted.\n";

        return false;
    }
    */
}
