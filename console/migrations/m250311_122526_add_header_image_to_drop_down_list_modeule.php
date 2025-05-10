<?php

use yii\db\Migration;

class m250311_122526_add_header_image_to_drop_down_list_modeule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("dropdown_list_lang","header_image",$this->string(255)->null());
        $this->addColumn("dropdown_list_lang","header_mobile_image",$this->string(255)->null());
        $this->addColumn("dropdown_list_lang","header_image_title",$this->string(255)->null());
        $this->addColumn("dropdown_list_lang","header_image_brief",$this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250311_122526_add_header_image_to_drop_down_list_modeule cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250311_122526_add_header_image_to_drop_down_list_modeule cannot be reverted.\n";

        return false;
    }
    */
}
