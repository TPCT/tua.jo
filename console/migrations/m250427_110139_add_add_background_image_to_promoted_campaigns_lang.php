<?php

use yii\db\Migration;

class m250427_110139_add_add_background_image_to_promoted_campaigns_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('promoted_campaigns_lang', 'backgroumd_image', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250427_110139_add_add_background_image_to_promoted_campaigns_lang cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250427_110139_add_add_background_image_to_promoted_campaigns_lang cannot be reverted.\n";

        return false;
    }
    */
}
