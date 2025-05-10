<?php

use yii\db\Migration;

/**
 * Class m241117_013033_add_object_fit_and_object_position_to_media_gallery
 */
class m241117_013033_add_object_fit_and_object_position_to_media_gallery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("media_gallery", "object_fit", $this->string(50)->defaultValue("contain"));
        $this->addColumn("media_gallery", "object_position", $this->string(50)->defaultValue("50% 50%"));

        $this->addColumn("media_gallery_lang", "header_image_object_fit", $this->string(50)->defaultValue("contain"));
        $this->addColumn("media_gallery_lang", "header_image_object_position", $this->string(50)->defaultValue("50% 50%"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241117_013033_add_object_fit_and_object_position_to_media_gallery cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241117_013033_add_object_fit_and_object_position_to_media_gallery cannot be reverted.\n";

        return false;
    }
    */
}
