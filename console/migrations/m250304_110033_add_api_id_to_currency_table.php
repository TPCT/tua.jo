<?php

use yii\db\Migration;

class m250304_110033_add_api_id_to_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('currency', 'api_id', $this->string());
        $this->addColumn('dropdown_list', 'api_id', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250304_110033_add_api_id_to_currency_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250304_110033_add_api_id_to_currency_table cannot be reverted.\n";

        return false;
    }
    */
}
