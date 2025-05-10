<?php

use yii\db\Migration;

/**
 * Class m241124_105438_add_object_fit_and_object_contain_to_speeches_table
 */
class m241124_105438_add_object_fit_and_object_contain_to_speeches_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn("speeches", "object_fit", $this->string(50)->defaultValue("contain")->after("image"));
        $this->addColumn("speeches", "object_position", $this->string(50)->defaultValue("50% 50%")->after("object_fit"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241124_105438_add_object_fit_and_object_contain_to_speeches_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241124_105438_add_object_fit_and_object_contain_to_speeches_table cannot be reverted.\n";

        return false;
    }
    */
}
