<?php

use yii\db\Migration;

class m250413_103532_add_slug_to_beneficiaries_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('beneficiaries_countries', 'slug', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_103532_add_slug_to_beneficiaries_countries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_103532_add_slug_to_beneficiaries_countries_table cannot be reverted.\n";

        return false;
    }
    */
}
