<?php

use yii\db\Migration;

class m250505_135601_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('recurring_items', 'amount_jod', $this->float(2)->notNull()->defaultValue(0));
        $this->alterColumn('recurring_items', 'amount_usd', $this->float(2)->notNull()->defaultValue(0));
        $this->alterColumn('recurring_items', 'quantity', $this->float(2)->notNull()->defaultValue(0));
        $this->alterColumn('recurring_items', 'total_jod', $this->float(2)->notNull()->defaultValue(0));
        $this->alterColumn('recurring_items', 'total_usd', $this->float(2)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250505_135601_change cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250505_135601_change cannot be reverted.\n";

        return false;
    }
    */
}
