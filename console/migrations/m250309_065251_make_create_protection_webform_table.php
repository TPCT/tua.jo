<?php

use yii\db\Migration;

class m250309_065251_make_create_protection_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('protection_webform', [
            'id' => $this->primaryKey(),

            'name' => $this->string(255)->defaultValue(null),
            'mobile_number' => $this->string(50)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),
            'contact_method_id' => $this->integer(11)->defaultValue(null),

            'inciden_date' => $this->date()->defaultValue(null),
            'location' => $this->string()->defaultValue(null),
            'description' => $this->text()->defaultValue(null),

            'survivor_name' => $this->string(255)->defaultValue(null),
            'survivor_position' => $this->string(255)->defaultValue(null),

            'alleged_name' => $this->string(255)->defaultValue(null),
            'alleged_position' => $this->string(255)->defaultValue(null),

            'witness_name' => $this->string(255)->defaultValue(null),

            'additional_information' => $this->text()->defaultValue(null),


            'created_at' => $this->integer()->defaultValue(null),
        ]);

        
        $this->createIndex(
            'idx-protection_webform-contact_method_id',
            'protection_webform',
            'contact_method_id'
        );
        $this->addForeignKey(
            'fk-protection_webform-contact_method_id',
            'protection_webform',
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
        echo "m250309_065251_make_create_protection_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_065251_make_create_protection_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
