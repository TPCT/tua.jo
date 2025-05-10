<?php

use yii\db\Migration;

class m250414_193914_drop_all_rating_relationship_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-rating_webform-question_2_id', 'rating_webform');
        $this->dropForeignKey('fk-rating_webform-question_3_id', 'rating_webform');
        $this->dropForeignKey('fk-rating_webform-question_5_id', 'rating_webform');
        $this->dropForeignKey('fk-rating_webform-question_6_id', 'rating_webform');
        $this->dropForeignKey('fk-rating_webform-question_7_id', 'rating_webform');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_193914_drop_all_rating_relationship_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_193914_drop_all_rating_relationship_table cannot be reverted.\n";

        return false;
    }
    */
}
