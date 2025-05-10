<?php

use yii\db\Migration;

class m250421_104315_add_fatwa_column_to_donation_program_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('donation_programs_lang', 'fatwa_file');

        $this->addColumn('donation_programs_lang', 'fatwa_file', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250421_104315_add_fatwa_column_to_donation_program_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250421_104315_add_fatwa_column_to_donation_program_table cannot be reverted.\n";

        return false;
    }
    */
}
