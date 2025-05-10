<?php

use yii\db\Migration;

class m250304_073120_add_file_url_column_to_offer_tendders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('offer_tenders', 'file', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250304_073120_add_file_url_column_to_offer_tendders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250304_073120_add_file_url_column_to_offer_tendders cannot be reverted.\n";

        return false;
    }
    */
}
