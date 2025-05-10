<?php

use yii\db\Migration;

/**
 * Class m241203_081159_create_header_image_bread_crumb_table
 */
class m241203_081159_create_header_image_bread_crumb_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('header_image_bread_crumb', [
            'id' => $this->primaryKey(),
            'header_image_id' => $this->integer(11),

            'button_url' => $this->string(255)->null(),
            'button_text_en' => $this->string(255)->null(),
            'button_text_ar' => $this->string(255)->null(),

            'published_at' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'revision' => $this->integer(11),
            'changed' => $this->integer(1),
            'view' => $this->string(255),
            'layout' => $this->string(255),
        ]);

        $this->createIndex(
            'idx-header_image_bread_crumb-header_image_id',
            'header_image_bread_crumb',
            'header_image_id'
        );

        $this->addForeignKey(
            'fk-header_image_bread_crumb-header_image_id',
            'header_image_bread_crumb',
            'header_image_id',
            'header_image',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241203_081159_create_header_image_bread_crumb_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241203_081159_create_header_image_bread_crumb_table cannot be reverted.\n";

        return false;
    }
    */
}
