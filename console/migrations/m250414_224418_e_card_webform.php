<?php

use yii\db\Migration;

class m250414_224418_e_card_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('e_card_webform', 'sender_mobile_number', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_224418_e_card_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_224418_e_card_webform cannot be reverted.\n";

        return false;
    }
    */
}
