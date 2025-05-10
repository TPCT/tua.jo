<?php

use yii\db\Migration;

class m250305_080442_add_image_column_to_bms_feature extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bms_feature', 'image', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250305_080442_add_image_column_to_bms_feature cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250305_080442_add_image_column_to_bms_feature cannot be reverted.\n";

        return false;
    }
    */
}
