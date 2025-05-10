<?php

use yii\db\Migration;

class m250428_105219_add_pdf_file_to_dropdown_list_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('dropdown_list_lang', 'pdf_file', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250428_105219_add_pdf_file_to_dropdown_list_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250428_105219_add_pdf_file_to_dropdown_list_lang cannot be reverted.\n";

        return false;
    }
    */
}
