<?php

use yii\db\Migration;

class m250302_104717_create_bms_feature_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("bms_feature", [
            'id' => $this->primaryKey(),
            'bms_id' => $this->integer(11),

            
            'title_en' => $this->string(255)->defaultValue(null),
            'title_ar' => $this->string(255)->defaultValue(null),
            
            'second_title_en' => $this->string(255)->defaultValue(null),
            'second_title_ar' => $this->string(255)->defaultValue(null),

            'brief_en' => $this->string(255)->defaultValue(null),
            'brief_ar' => $this->string(255)->defaultValue(null),

            
            'content_en' => $this->text()->defaultValue(null),
            'content_ar' => $this->text()->defaultValue(null),

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


        // creates index for column `parent_id`
        $this->createIndex(
            'idx-bms_feature-bms_id',
            'bms_feature',
            'bms_id'
        );

        $this->addForeignKey(
            'fk-bms_feature-bms_id',
            'bms_feature',
            'bms_id',
            'bms',
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
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250302_104717_create_bms_feature_table cannot be reverted.\n";

        return false;
    }
    */
}
