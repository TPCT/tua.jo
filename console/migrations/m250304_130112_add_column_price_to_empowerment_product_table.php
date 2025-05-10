<?php

use yii\db\Migration;

class m250304_130112_add_column_price_to_empowerment_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('empowerment_product', 'price', $this->integer(11));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250304_130112_add_column_price_to_empowerment_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250304_130112_add_column_price_to_empowerment_product_table cannot be reverted.\n";

        return false;
    }
    */
}
