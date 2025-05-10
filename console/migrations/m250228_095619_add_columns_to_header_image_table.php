<?php

use yii\db\Migration;

class m250228_095619_add_columns_to_header_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    
        $this->addColumn('header_image', 'weight_order', $this->tinyInteger()->defaultValue(10));
        $this->addColumn('header_image', 'status', $this->tinyInteger()->defaultValue(0));
        $this->addColumn('header_image', 'published_at', $this->integer()->null());
        $this->addColumn('header_image', 'revision', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('header_image', 'changed', $this->tinyInteger(1)->notNull()->defaultValue(0));
        $this->addColumn('header_image', 'reject_note', $this->string()->null());
        $this->addColumn('header_image', 'view', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250228_095619_add_columns_to_header_image_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250228_095619_add_columns_to_header_image_table cannot be reverted.\n";

        return false;
    }
    */
}
