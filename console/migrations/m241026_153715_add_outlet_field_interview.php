<?php

use yii\db\Migration;

/**
 * Class m241026_153715_add_outlet_field_interview
 */
class m241026_153715_add_outlet_field_interview extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("interviews", "media_outlet_id", $this->integer(11)->after("trailer")->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241026_153715_add_outlet_field_interview cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241026_153715_add_outlet_field_interview cannot be reverted.\n";

        return false;
    }
    */
}
