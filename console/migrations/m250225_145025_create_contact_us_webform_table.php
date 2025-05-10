<?php

use yii\db\Migration;

class m250225_145025_create_contact_us_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contact_us_webform', [
            'id' => $this->primaryKey(),

            'name' => $this->string(255)->defaultValue(null),
            'mobile_number' => $this->string(50)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),
            'purpose_id' => $this->integer(11)->defaultValue(null),

            'mobile_number' => $this->string(255)->defaultValue(null),

            'message' => $this->text()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
        ]);


        $this->createIndex(
            'idx-contact_us_webform-purpose_id',
            'contact_us_webform',
            'purpose_id'
        );


        $this->addForeignKey(
            'fk-contact_us_webform-purpose_id',
            'contact_us_webform',
            'purpose_id',
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
        echo "m250225_145025_create_contact_us_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_145025_create_contact_us_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
