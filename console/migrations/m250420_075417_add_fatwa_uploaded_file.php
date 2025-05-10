<?php

use yii\db\Migration;

class m250420_075417_add_fatwa_uploaded_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_programs_lang', 'fatwa_file', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_075417_add_fatwa_uploaded_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_075417_add_fatwa_uploaded_file cannot be reverted.\n";

        return false;
    }
    */
}
