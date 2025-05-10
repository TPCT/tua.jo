<?php

use yii\db\Migration;

class m250409_114141_rating_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rating_webform', [
            'id' => $this->primaryKey(),

            'question_1_id' => $this->integer(11)->defaultValue(null),
            'question_2_id' => $this->integer(11)->defaultValue(null),
            'question_2_text' => $this->string()->defaultValue(null),
            'question_3_id' => $this->integer(11)->defaultValue(null),
            'question_4_text' => $this->string()->defaultValue(null),
            'question_5_id' => $this->integer(11)->defaultValue(null),
            'question_6_id' => $this->integer(11)->defaultValue(null),
            'question_7_id' => $this->integer(11)->defaultValue(null),
            'question_8_text' => $this->text()->defaultValue(null),

            'created_at' => $this->integer()->defaultValue(null),
        ]);
        $this->createIndex(
            'idx-rating_webform-question_1_id',
            'rating_webform',
            'question_1_id'
        );
        $this->addForeignKey(
            'fk-rating_webform-question_1_id',
            'rating_webform',
            'question_1_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex(
            'idx-rating_webform-question_2_id',
            'rating_webform',
            'question_2_id'
        );
        $this->addForeignKey(
            'fk-rating_webform-question_2_id',
            'rating_webform',
            'question_2_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex(
            'idx-rating_webform-question_3_id',
            'rating_webform',
            'question_3_id'
        );
        $this->addForeignKey(
            'fk-rating_webform-question_3_id',
            'rating_webform',
            'question_3_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex(
            'idx-rating_webform-question_5_id',
            'rating_webform',
            'question_5_id'
        );
        $this->addForeignKey(
            'fk-rating_webform-question_5_id',
            'rating_webform',
            'question_5_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex(
            'idx-rating_webform-question_6_id',
            'rating_webform',
            'question_6_id'
        );
        $this->addForeignKey(
            'fk-rating_webform-question_6_id',
            'rating_webform',
            'question_6_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex(
            'idx-rating_webform-question_7_id',
            'rating_webform',
            'question_7_id'
        );
        $this->addForeignKey(
            'fk-rating_webform-question_7_id',
            'rating_webform',
            'question_7_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250409_114141_rating_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250409_114141_rating_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
