<?php

use yii\db\Migration;

class m250413_080827_make_revision_with_default_zero extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('beneficiaries_countries', 'revision', $this->integer()->defaultValue(0));
        $this->alterColumn('beneficiaries_countries', 'changed', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_080827_make_revision_with_default_zero cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_080827_make_revision_with_default_zero cannot be reverted.\n";

        return false;
    }
    */
}
