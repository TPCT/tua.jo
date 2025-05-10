<?php

use yii\db\Migration;

class m250406_024701_create_donation_programs_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donation_programs}}', [
            'id' => $this->primaryKey(),
            'donation_type_id' => $this->integer()->notNull(),
            'campaign_id' => $this->integer()->null(),
            'type' => $this->string()->notNull(),
            'image' => $this->string()->null(),
            'thumb_image' => $this->string()->null(),
            'tag_icon' => $this->string()->null(),
            'weight' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'slug' => $this->string()->notNull(),
            'color' => $this->string(10)->notNull(),
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

        $this->createIndex('idx-donation_programs-created_by', 'donation_programs', 'created_by');
        $this->createIndex('idx-donation_programs-updated_by', 'donation_programs', 'updated_by');


        $this->addForeignKey(
            'fk-donation_programs-created_by',
            'donation_programs',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_programs-updated_by',
            'donation_programs',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%donation_programs_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6)->notNull(),
            'title' => $this->string(255)->notNull(),
            'tag' => $this->string(255)->notNull(),
            'brief' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
        ]);

        $this->createIndex('idx-donation_programs_lang-parent_id', '{{%donation_programs_lang}}', 'parent_id');
        $this->addForeignKey(
            'fk-donation_programs_lang-parent_id',
            '{{%donation_programs_lang}}',
            'parent_id',
            '{{%donation_programs}}',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%donation_programs_tabs}}', [
            'id' => $this->primaryKey(),
            'donation_program_id' => $this->integer()->notNull(),

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

        $this->createIndex('idx-donation_programs_tabs-created_by', 'donation_programs_tabs', 'created_by');
        $this->createIndex('idx-donation_programs_tabs-updated_by', 'donation_programs_tabs', 'updated_by');


        $this->addForeignKey(
            'fk-donation_programs_tabs-created_by',
            'donation_programs_tabs',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_programs_tabs-updated_by',
            'donation_programs_tabs',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-donation_programs_tabs-donation_program_id', '{{%donation_programs_tabs}}', 'donation_program_id');
        $this->addForeignKey(
            'fk-donation_programs_tabs-donation_program_id',
            '{{%donation_programs_tabs}}',
            'donation_program_id',
            '{{%donation_programs}}',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%donation_programs_items}}', [
            'id' => $this->primaryKey(),
            'donation_program_id' => $this->integer()->notNull(),
            'donation_type_id' => $this->integer(),
            'campaign_id' => $this->integer(),

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

        $this->createIndex('idx-donation_programs_items-created_by', 'donation_programs_items', 'created_by');
        $this->createIndex('idx-donation_programs_items-updated_by', 'donation_programs_items', 'updated_by');


        $this->addForeignKey(
            'fk-donation_programs_items-created_by',
            'donation_programs_items',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donation_programs_items-updated_by',
            'donation_programs_items',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-donation_programs_items-donation_program_id', '{{%donation_programs_items}}', 'donation_program_id');
        $this->addForeignKey(
            'fk-donation_programs_items-donation_program_id',
            '{{%donation_programs_items}}',
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
        echo "m250406_024701_create_donation_programs_tables cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_024701_create_donation_programs_tables cannot be reverted.\n";

        return false;
    }
    */
}
