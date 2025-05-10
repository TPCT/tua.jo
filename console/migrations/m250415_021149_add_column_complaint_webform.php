<?php

use yii\db\Migration;

class m250415_021149_add_column_complaint_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('complaint_webform', 'survey_type', $this->integer()->notNull());
        $this->addColumn('complaint_webform', 'by_phone', $this->boolean()->notNull());
        $this->addColumn('complaint_webform', 'by_email', $this->boolean()->notNull());
        $this->addColumn('complaint_webform', 'prefer_not_to_communicate', $this->boolean()->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250415_021149_add_column_complaint_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_021149_add_column_complaint_webform cannot be reverted.\n";

        return false;
    }
    */
}
