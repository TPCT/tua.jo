<?php

use yii\db\Migration;

class m250303_131404_add_columns_to_media_upload_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('media_upload', 'caption_en', $this->string()->defaultValue(null));
        $this->addColumn('media_upload', 'caption_ar', $this->string()->defaultValue(null));
        $this->addColumn('media_upload', 'published_at', $this->integer()->defaultValue(null));
        $this->addColumn('media_upload', 'object_fit', $this->string()->defaultValue('contain'));
        $this->addColumn('media_upload', 'object_position', $this->string()->defaultValue('50% 50%'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250303_131404_add_columns_to_media_upload_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250303_131404_add_columns_to_media_upload_table cannot be reverted.\n";

        return false;
    }
    */
}
