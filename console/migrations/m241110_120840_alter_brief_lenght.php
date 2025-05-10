<?php

use yii\db\Migration;

/**
 * Class m241110_120840_alter_brief_lenght
 */
class m241110_120840_alter_brief_lenght extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("speeches_lang","brief", $this->string(1000)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241110_120840_alter_brief_lenght cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241110_120840_alter_brief_lenght cannot be reverted.\n";

        return false;
    }
    */
}
