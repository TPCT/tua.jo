<?php

use yii\db\Migration;

class m250311_124703_add_promoted_to_impact_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('annual_report', 'promoted_to_our_impact', $this->tinyInteger(3)->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250311_124703_add_promoted_to_impact_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250311_124703_add_promoted_to_impact_column cannot be reverted.\n";

        return false;
    }
    */
}
