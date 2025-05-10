<?php

use yii\db\Migration;

class m250309_093553_edit_donation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%donation}}', 'is_progress', 'in_progress');
        $this->dropColumn('{{%donation}}', 'progress_value');
        $this->dropColumn('{{%donation}}', 'promoted_to_homepage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250309_093553_edit_donation_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_093553_edit_donation_table cannot be reverted.\n";

        return false;
    }
    */
}
