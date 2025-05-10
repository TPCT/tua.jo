<?php

use yii\db\Migration;

class m250413_133516_donation_campain_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('donation_campain_webform', [
            'id' => $this->primaryKey(),

            'name' => $this->string(255)->defaultValue(null),
            'mobile_number' => $this->string(50)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),
            'campaing_name' => $this->string(255)->defaultValue(null),
            'reason_id' => $this->integer(11)->defaultValue(null),
            'donation_goal' => $this->string(255)->defaultValue(null),

            'start_date' => $this->date()->defaultValue(null),
            'end_date' => $this->date()->defaultValue(null),
            'donation_program_id' => $this->integer(11)->defaultValue(null),
            'e_card_id' => $this->integer(11)->defaultValue(null),

            'message' => $this->text()->defaultValue(null),

            'created_at' => $this->integer()->defaultValue(null),
        ]);

        $this->createIndex(
            'idx-donation_campain_webform-reason_id',
            'donation_campain_webform',
            'reason_id'
        );
        $this->addForeignKey(
            'fk-donation_campain_webform-reason_id',
            'donation_campain_webform',
            'reason_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );



        $this->createIndex(
            'idx-donation_campain_webform-donation_program_id',
            'donation_campain_webform',
            'donation_program_id'
        );
        $this->addForeignKey(
            'fk-donation_campain_webform-donation_program_id',
            'donation_campain_webform',
            'donation_program_id',
            'donation_programs',
            'id',
            'RESTRICT',
            'CASCADE'
        );



        $this->createIndex(
            'idx-donation_campain_webform-e_card_id',
            'donation_campain_webform',
            'e_card_id'
        );
        $this->addForeignKey(
            'fk-donation_campain_webform-e_card_id',
            'donation_campain_webform',
            'e_card_id',
            'e_cards',
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
        echo "m250413_133516_donation_campain_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_133516_donation_campain_webform cannot be reverted.\n";

        return false;
    }
    */
}
