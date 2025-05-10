<?php

use yii\db\Migration;

/**
 * Class m241105_200903_chnage_media_outlet_interview
 */
class m241105_200903_chnage_media_outlet_interview extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // Drop `media_outlet_id` column from `interviews` table
        $this->dropColumn('interviews', 'media_outlet_id');

        // Add `media_outlet` column to `interviews_lang` table
        $this->addColumn('interviews_lang', 'media_outlet', $this->string(255)->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241105_200903_chnage_media_outlet_interview cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_200903_chnage_media_outlet_interview cannot be reverted.\n";

        return false;
    }
    */
}
