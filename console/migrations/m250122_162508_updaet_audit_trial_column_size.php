<?php

use yii\db\Migration;

class m250122_162508_updaet_audit_trial_column_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("audit_trail","old_value","MEDIUMTEXT");
        $this->alterColumn("audit_trail","new_value","MEDIUMTEXT");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250122_162508_updaet_audit_trial_column_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250122_162508_updaet_audit_trial_column_size cannot be reverted.\n";

        return false;
    }
    */
}
