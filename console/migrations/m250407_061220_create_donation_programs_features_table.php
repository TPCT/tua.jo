<?php

use yii\db\Migration;

class m250407_061220_create_donation_programs_features_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donation_programs_features}}', [
            'id' => $this->primaryKey(),
            'donation_program_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'title_en' => $this->string()->notNull(),
            'title_ar' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'published_at' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'revision' => $this->integer(11),
            'changed' => $this->integer(1),
            'view' => $this->string(255),
            'layout' => $this->string(255),
        ]);

        $this->createIndex('idx-donation_programs_features-created_by', 'donation_programs_features', 'created_by');
        $this->createIndex('idx-donation_programs_features-updated_by', 'donation_programs_features', 'updated_by');


        $this->addForeignKey(
            'fk-donation_programs_features-created_by',
            'donation_programs_features',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_programs_features-updated_by',
            'donation_programs_features',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-donation_programs_features-donation_program_id', '{{%donation_programs_features}}', 'donation_program_id');
        $this->addForeignKey(
            'fk-donation_programs_features-donation_program_id',
            '{{%donation_programs_features}}',
            'donation_program_id',
            '{{%donation_programs}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250407_061220_create_donation_programs_features_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_061220_create_donation_programs_features_table cannot be reverted.\n";

        return false;
    }
    */
}
