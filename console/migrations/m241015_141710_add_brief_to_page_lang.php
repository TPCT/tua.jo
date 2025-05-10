<?php

use yii\db\Migration;

/**
 * Class m241015_141710_add_brief_to_page_lang
 */
class m241015_141710_add_brief_to_page_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('page_lang', 'brief', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241015_141710_add_brief_to_page_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_141710_add_brief_to_page_lang cannot be reverted.\n";

        return false;
    }
    */
}
