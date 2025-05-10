<?php

use yii\db\Migration;

class m250420_071518_create_donation_programs_promotions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donation_programs_promotions}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'donation_program_id' => $this->integer(),
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

        $this->createIndex('idx-donation_programs_promotions-created_by', 'donation_programs_promotions', 'created_by');
        $this->createIndex('idx-donation_programs_promotions-updated_by', 'donation_programs_promotions', 'updated_by');


        $this->addForeignKey(
            'fk-donation_programs_promotions-created_by',
            'donation_programs_promotions',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_programs_promotions-updated_by',
            'donation_programs_promotions',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-donation_programs_promotions-parent_id', '{{%donation_programs_promotions}}', 'parent_id');
        $this->addForeignKey(
            'fk-donation_programs_promotions-parent_id',
            '{{%donation_programs_promotions}}',
            'parent_id',
            '{{%donation_programs}}',
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-donation_programs_promotions-donation_program_id', '{{%donation_programs_promotions}}', 'donation_program_id');
        $this->addForeignKey(
            'fk-donation_programs_promotions-donation_program_id',
            '{{%donation_programs_promotions}}',
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
        echo "m250420_071518_create_donation_programs_promotions_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_071518_create_donation_programs_promotions_table cannot be reverted.\n";

        return false;
    }
    */
}
