<?php

use yii\db\Migration;

/**
 * Class m241014_204952_update_youtube_links_table
 */
class m241014_204952_update_youtube_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('youtube_links', 'youtube_embedded_links');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241014_204952_update_youtube_links_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241014_204952_update_youtube_links_table cannot be reverted.\n";

        return false;
    }
    */
}
