<?php

use yii\db\Migration;

/**
 * Class m241106_115131_add_object_fit_and_object_contain_to_news_table
 */
class m241106_115131_add_object_fit_and_object_contain_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("news", "object_fit", $this->string(50)->defaultValue("contain"));
        $this->addColumn("news", "object_position", $this->string(50)->defaultValue("50% 50%"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241106_115131_add_object_fit_and_object_contain_to_news_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241106_115131_add_object_fit_and_object_contain_to_news_table cannot be reverted.\n";

        return false;
    }
    */
}
