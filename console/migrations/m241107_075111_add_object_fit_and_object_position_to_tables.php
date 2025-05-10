<?php

use yii\db\Migration;

/**
 * Class m241107_075111_add_object_fit_and_object_position_to_tables
 */
class m241107_075111_add_object_fit_and_object_position_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn("bms_lang", "object_fit", $this->string(50)->defaultValue("contain"));
        $this->addColumn("bms_lang", "object_position", $this->string(50)->defaultValue("50% 50%"));

        $this->addColumn("dropdown_list_lang", "object_fit", $this->string(50)->defaultValue("contain"));
        $this->addColumn("dropdown_list_lang", "object_position", $this->string(50)->defaultValue("50% 50%"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241107_075111_add_object_fit_and_object_position_to_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241107_075111_add_object_fit_and_object_position_to_tables cannot be reverted.\n";

        return false;
    }
    */
}
