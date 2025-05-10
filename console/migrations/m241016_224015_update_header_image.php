<?php

use yii\db\Migration;

/**
 * Class m241016_224015_update_header_image
 */
class m241016_224015_update_header_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('header_image_lang', 'mobile_image', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241016_224015_update_header_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241016_224015_update_header_image cannot be reverted.\n";

        return false;
    }
    */
}
