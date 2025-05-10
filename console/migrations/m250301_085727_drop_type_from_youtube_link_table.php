<?php

use yii\db\Migration;

class m250301_085727_drop_type_from_youtube_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('youtube_links', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250301_085727_drop_type_from_youtube_link_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250301_085727_drop_type_from_youtube_link_table cannot be reverted.\n";

        return false;
    }
    */
}
