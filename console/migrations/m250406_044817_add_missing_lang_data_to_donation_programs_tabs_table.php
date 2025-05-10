<?php

use yii\db\Migration;

class m250406_044817_add_missing_lang_data_to_donation_programs_tabs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%donation_programs_tabs}}', 'title_en', $this->string()->null());
        $this->addColumn('{{%donation_programs_tabs}}', 'title_ar', $this->string()->null());
        $this->addColumn('{{%donation_programs_tabs}}', 'brief_en', $this->text()->null());
        $this->addColumn('{{%donation_programs_tabs}}', 'brief_ar', $this->text()->null());

        $this->dropForeignKey('fk-donation_programs_tabs_lang-parent_id', '{{%donation_programs_tabs_lang}}');
        $this->dropIndex('idx-donation_programs_tabs_lang-parent_id', '{{%donation_programs_tabs_lang}}');
        $this->dropTable('{{%donation_programs_tabs_lang}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_044817_add_missing_lang_data_to_donation_programs_tabs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_044817_add_missing_lang_data_to_donation_programs_tabs_table cannot be reverted.\n";

        return false;
    }
    */
}
