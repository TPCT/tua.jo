<?php

use yii\db\Migration;

class m250416_095118_promote_to_zakat_calculation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("faq", "promote_to_zakat", $this->tinyInteger(1)->defaultValue(0)->after("status"));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250416_095118_promote_to_zakat_calculation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250416_095118_promote_to_zakat_calculation cannot be reverted.\n";

        return false;
    }
    */
}
