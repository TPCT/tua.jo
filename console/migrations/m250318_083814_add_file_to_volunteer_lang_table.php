<?php

use yii\db\Migration;

class m250318_083814_add_file_to_volunteer_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('volunteer_lang', 'file', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250318_083814_add_file_to_volunteer_lang_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250318_083814_add_file_to_volunteer_lang_table cannot be reverted.\n";

        return false;
    }
    */
}
