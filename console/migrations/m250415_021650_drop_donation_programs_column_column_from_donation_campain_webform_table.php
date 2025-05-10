<?php

use yii\db\Migration;

class m250415_021650_drop_donation_programs_column_column_from_donation_campain_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-donation_campain_webform-donation_program_id', 'donation_campain_webform');
        $this->dropIndex('idx-donation_campain_webform-donation_program_id', 'donation_campain_webform');
        $this->dropColumn('donation_campain_webform', 'donation_program_id');
        $this->addColumn('donation_campain_webform', 'donation_type_id', $this->integer()->null());

        $this->createIndex(
            'idx-donation_campain_webform-donation_type_id',
            'donation_campain_webform',
            'donation_type_id'
        );
        $this->addForeignKey(
            'fk-donation_campain_webform-donation_type_id',
            'donation_campain_webform',
            'donation_type_id',
            'donation_types',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_021650_drop_donation_programs_column_column_from_donation_campain_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
