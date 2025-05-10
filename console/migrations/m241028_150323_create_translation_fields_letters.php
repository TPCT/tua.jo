<?php

use yii\db\Migration;

/**
 * Class m241028_150323_create_translation_fields_letters
 */
class m241028_150323_create_translation_fields_letters extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropColumn('letters', 'trailer');
        $this->dropColumn('letters', 'occasion');
        $this->dropColumn('letters', 'to');

        $this->addColumn('letters_lang', 'trailer', $this->string(255));
        $this->addColumn('letters_lang', 'occasion', $this->string(255));
        $this->addColumn('letters_lang', 'to', $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241028_150323_create_translation_fields_letters cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_150323_create_translation_fields_letters cannot be reverted.\n";

        return false;
    }
    */
}
