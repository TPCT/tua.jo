<?php

use yii\db\Migration;

class m250319_093011_file_label_to_volunteer_program extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('volunteer_lang', 'file_label', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250319_093011_file_label_to_volunteer_program cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250319_093011_file_label_to_volunteer_program cannot be reverted.\n";

        return false;
    }
    */
}
