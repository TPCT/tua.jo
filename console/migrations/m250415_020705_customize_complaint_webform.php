<?php

use yii\db\Migration;

class m250415_020705_customize_complaint_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-complaint_webform-contact_method_id', 'complaint_webform');
        $this->dropForeignKey('fk-complaint_webform-message_type_id', 'complaint_webform');

        $this->dropColumn('complaint_webform','message_type_id');
        $this->dropColumn('complaint_webform','contact_method_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250415_020705_customize_complaint_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_020705_customize_complaint_webform cannot be reverted.\n";

        return false;
    }
    */
}
