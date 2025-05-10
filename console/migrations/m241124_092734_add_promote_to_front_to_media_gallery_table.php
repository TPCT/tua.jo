<?php

use yii\db\Migration;

/**
 * Class m241124_092734_add_promote_to_front_to_media_gallery_table
 */
class m241124_092734_add_promote_to_front_to_media_gallery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("media_gallery", "promote_to_front", $this->tinyInteger(1)->after("comment_status"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241124_092734_add_promote_to_front_to_media_gallery_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241124_092734_add_promote_to_front_to_media_gallery_table cannot be reverted.\n";

        return false;
    }
    */
}
