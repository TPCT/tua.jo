<?php

use yii\db\Migration;

/**
 * Class m241028_151300_create_translation_fields_letters_2
 */
class m241028_151300_create_translation_fields_letters_2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('letters', 'header_line');

        $this->addColumn('letters_lang', 'header_line', $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241028_151300_create_translation_fields_letters_2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_151300_create_translation_fields_letters_2 cannot be reverted.\n";

        return false;
    }
    */
}
