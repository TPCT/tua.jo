<?php

use yii\db\Migration;

class m250414_075719_add_columns_to_e_cards extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("e_cards", "promote_to_form", $this->tinyInteger(1)->after("status"));
        $this->addColumn("e_cards_lang", "brief", $this->text()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_075719_add_columns_to_e_cards cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_075719_add_columns_to_e_cards cannot be reverted.\n";

        return false;
    }
    */
}
