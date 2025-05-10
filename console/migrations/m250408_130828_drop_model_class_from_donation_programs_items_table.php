<?php

use yii\db\Migration;

class m250408_130828_drop_model_class_from_donation_programs_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%donation_programs_items}}', 'model_class');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250408_130828_drop_model_class_from_donation_programs_items_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250408_130828_drop_model_class_from_donation_programs_items_table cannot be reverted.\n";

        return false;
    }
    */
}
