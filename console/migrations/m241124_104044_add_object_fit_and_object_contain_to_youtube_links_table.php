<?php

use yii\db\Migration;

/**
 * Class m241124_104044_add_object_fit_and_object_contain_to_youtube_links_table
 */
class m241124_104044_add_object_fit_and_object_contain_to_youtube_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("youtube_links", "object_fit", $this->string(50)->defaultValue("contain")->after("cover_image"));
        $this->addColumn("youtube_links", "object_position", $this->string(50)->defaultValue("50% 50%")->after("object_fit"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241124_104044_add_object_fit_and_object_contain_to_youtube_links_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241124_104044_add_object_fit_and_object_contain_to_youtube_links_table cannot be reverted.\n";

        return false;
    }
    */
}
