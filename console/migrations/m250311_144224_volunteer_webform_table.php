<?php

use yii\db\Migration;

class m250311_144224_volunteer_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('volunteer_webform', [
            'id' => $this->primaryKey(),

            'name' => $this->string(255)->defaultValue(null),
            'volunteer_date' => $this->date()->defaultValue(null),

            'number_type_id' => $this->integer(11)->defaultValue(null),
            'mobile_number' => $this->string(50)->defaultValue(null),

            'gender' => $this->string(255)->defaultValue(null),
            
            'nationality_id' => $this->integer(255)->defaultValue(null),
            'country_id' => $this->integer(255)->defaultValue(null),
            'city_id' => $this->integer(255)->defaultValue(null),

            'occupation_id' => $this->integer(11)->defaultValue(null),
            'university_name' => $this->string(255)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),

            'volunteer_id' => $this->integer(11)->defaultValue(null),

            'participated_volunteer_type' => $this->string(255)->defaultValue(null),
            'specify' => $this->string(255)->defaultValue(null),

            'hear_about_volunteer_id' => $this->integer(11)->defaultValue(null),


            'created_at' => $this->integer()->defaultValue(null),
        ]);


        $this->createIndex(
            'idx-volunteer_webform-number_type_id',
            'volunteer_webform',
            'number_type_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-number_type_id',
            'volunteer_webform',
            'number_type_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex(
            'idx-volunteer_webform-nationality_id',
            'volunteer_webform',
            'nationality_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-nationality_id',
            'volunteer_webform',
            'nationality_id',
            'countries',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex(
            'idx-volunteer_webform-country_id',
            'volunteer_webform',
            'country_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-country_id',
            'volunteer_webform',
            'country_id',
            'countries',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex(
            'idx-volunteer_webform-city_id',
            'volunteer_webform',
            'city_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-city_id',
            'volunteer_webform',
            'city_id',
            'city',
            'id',
            'RESTRICT',
            'CASCADE'
        );









        $this->createIndex(
            'idx-volunteer_webform-occupation_id',
            'volunteer_webform',
            'occupation_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-occupation_id',
            'volunteer_webform',
            'occupation_id',
            'dropdown_list',
            'id',
            'RESTRICT',
            'CASCADE'
        );




        $this->createIndex(
            'idx-volunteer_webform-volunteer_id',
            'volunteer_webform',
            'volunteer_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-volunteer_id',
            'volunteer_webform',
            'volunteer_id',
            'volunteer',
            'id',
            'RESTRICT',
            'CASCADE'
        );




        $this->createIndex(
            'idx-volunteer_webform-hear_about_volunteer_id',
            'volunteer_webform',
            'hear_about_volunteer_id'
        );
        $this->addForeignKey(
            'fk-volunteer_webform-hear_about_volunteer_id',
            'volunteer_webform',
            'hear_about_volunteer_id',
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
        echo "m250311_144224_volunteer_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250311_144224_volunteer_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
