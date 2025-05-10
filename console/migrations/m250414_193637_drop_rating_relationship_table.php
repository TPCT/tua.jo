<?php

use yii\db\Migration;

class m250414_193637_drop_rating_relationship_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-rating_webform-question_1_id', 'rating_webform');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_193637_drop_rating_relationship_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_193637_drop_rating_relationship_table cannot be reverted.\n";

        return false;
    }
    */
}
