<?php

use yii\db\Migration;

/**
 * Class m241028_161642_create_translation_fields_interviews
 */
class m241028_161642_create_translation_fields_interviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('interviews', 'trailer');

        $this->addColumn('interviews_lang', 'trailer', $this->string(255));
        $this->addColumn('interviews_lang', 'appended_to_interviewer', $this->string(255));
        $this->addColumn('interviews_lang', 'appended_to_outlet', $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241028_161642_create_translation_fields_interviews cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_161642_create_translation_fields_interviews cannot be reverted.\n";

        return false;
    }
    */
}
