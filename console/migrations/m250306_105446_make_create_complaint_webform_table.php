<?php

use yii\db\Migration;

class m250306_105446_make_create_complaint_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('complaint_webform', [
            'id' => $this->primaryKey(),

            'message_type_id' => $this->integer(11)->defaultValue(null),

            'name' => $this->string(255)->defaultValue(null),
            'mobile_number' => $this->string(50)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),

            'message' => $this->text()->defaultValue(null),

            'contact_method_id' => $this->integer(11)->defaultValue(null),
            'another_way' => $this->string(255)->defaultValue(null),


            'created_at' => $this->integer()->defaultValue(null),
        ]);


        $this->createIndex(
            'idx-complaint_webform-message_type_id',
            'complaint_webform',
            'message_type_id'
        );
        $this->addForeignKey(
            'fk-complaint_webform-message_type_id',
            'complaint_webform',
            'message_type_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );


        $this->createIndex(
            'idx-complaint_webform-contact_method_id',
            'complaint_webform',
            'contact_method_id'
        );
        $this->addForeignKey(
            'fk-complaint_webform-contact_method_id',
            'complaint_webform',
            'contact_method_id',
            'dropdown_list',
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
        echo "m250306_105446_make_create_complaint_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250306_105446_make_create_complaint_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
