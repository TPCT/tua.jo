<?php

use yii\db\Migration;

/**
 * Class m241028_085211_add_second_title_to_speech_lang
 */
class m241028_085211_add_second_title_to_speech_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("speeches_lang", "second_title", $this->string(255)->null()->after("title"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241028_085211_add_second_title_to_speech_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_085211_add_second_title_to_speech_lang cannot be reverted.\n";

        return false;
    }
    */
}
