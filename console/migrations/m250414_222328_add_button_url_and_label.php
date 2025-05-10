<?php

use yii\db\Migration;

class m250414_222328_add_button_url_and_label extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('promoted_campaigns_lang', 'button_label', $this->string()->defaultValue(null));
        $this->addColumn('promoted_campaigns', 'button_url', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_222328_add_button_url_and_label cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_222328_add_button_url_and_label cannot be reverted.\n";

        return false;
    }
    */
}
