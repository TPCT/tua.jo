<?php

use yii\db\Migration;

class m250407_095458_create_donation_program_parents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donation_program_parents}}', [
            'id' => $this->primaryKey(),
            'donation_program_id' => $this->integer()->notNull(),
            'title_en' => $this->string()->notNull(),
            'title_ar' => $this->string()->notNull(),
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

        $this->createIndex('idx-donation_program_parents-created_by', 'donation_program_parents', 'created_by');
        $this->createIndex('idx-donation_program_parents-updated_by', 'donation_program_parents', 'updated_by');


        $this->addForeignKey(
            'fk-donation_program_parents-created_by',
            'donation_program_parents',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_program_parents-updated_by',
            'donation_program_parents',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-donation_program_parents-donation_program_id', '{{%donation_program_parents}}', 'donation_program_id');
        $this->addForeignKey(
            'fk-donation_program_parents-donation_program_id',
            '{{%donation_program_parents}}',
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
        echo "m250407_095458_create_donation_program_parents_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_095458_create_donation_program_parents_table cannot be reverted.\n";

        return false;
    }
    */
}
