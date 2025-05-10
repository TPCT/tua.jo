<?php

use yii\db\Migration;

class m250414_215318_add_donor_id_to_e_card_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('e_card_webform', 'donor_id', $this->string()->notNull());




    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_215318_add_donor_id_to_e_card_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_215318_add_donor_id_to_e_card_webform cannot be reverted.\n";

        return false;
    }
    */
}
