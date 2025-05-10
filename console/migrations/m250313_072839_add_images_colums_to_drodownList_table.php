<?php

use yii\db\Migration;

class m250313_072839_add_images_colums_to_drodownList_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('dropdown_list_lang', 'button_text', $this->string()->defaultValue(null));
        $this->addColumn('dropdown_list_lang', 'button_2_text', $this->string()->defaultValue(null));
        $this->addColumn('dropdown_list_lang', 'button_image_1', $this->string()->defaultValue(null));
        $this->addColumn('dropdown_list_lang', 'button_image_2', $this->string()->defaultValue(null));

        $this->addColumn('dropdown_list', 'url_1', $this->string()->defaultValue(null));
        $this->addColumn('dropdown_list', 'url_2', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250313_072839_add_images_colums_to_drodownList_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250313_072839_add_images_colums_to_drodownList_table cannot be reverted.\n";

        return false;
    }
    */
}
