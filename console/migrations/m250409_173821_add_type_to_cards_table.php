<?php

use yii\db\Migration;

class m250409_173821_add_type_to_cards_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cards}}', 'type', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_173821_add_type_to_cards_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_173821_add_type_to_cards_table cannot be reverted.\n";

        return false;
    }
    */
}
