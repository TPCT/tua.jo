<?php

use yii\db\Migration;

/**
 * Class m241021_173516_alter_second_title_to_be_500_characters
 */
class m241021_173516_alter_second_title_to_be_500_characters extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("bms_lang", "second_title", $this->string(500)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241021_173516_alter_second_title_to_be_500_characters cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_173516_alter_second_title_to_be_500_characters cannot be reverted.\n";

        return false;
    }
    */
}
