<?php

use yii\db\Migration;

class m250413_095513_add_img_to_beneficiaries_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('beneficiaries_countries', 'img', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_095513_add_img_to_beneficiaries_countries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_095513_add_img_to_beneficiaries_countries_table cannot be reverted.\n";

        return false;
    }
    */
}
