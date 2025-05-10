<?php

use yii\db\Migration;

class m250413_071941_create_beneficiaries_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%beneficiaries_countries}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
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

        $this->createIndex('idx-beneficiaries_countries-created_by', 'beneficiaries_countries', 'created_by');
        $this->createIndex('idx-beneficiaries_countries-updated_by', 'beneficiaries_countries', 'updated_by');


        $this->addForeignKey(
            'fk-beneficiaries_countries-created_by',
            'beneficiaries_countries',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-beneficiaries_countries-updated_by',
            'beneficiaries_countries',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%beneficiaries_countries_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6)->notNull(),
            'title' => $this->string(255)->notNull(),
            'brief' => $this->string(255)->notNull(),
        ]);


        $this->createIndex('idx-beneficiaries_countries_lang-parent_id', '{{%beneficiaries_countries_lang}}', 'parent_id');
        $this->addForeignKey(
            'fk-beneficiaries_countries_lang-parent_id',
            '{{%beneficiaries_countries_lang}}',
            'parent_id',
            '{{%beneficiaries_countries}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250413_071941_create_beneficiaries_countries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_071941_create_beneficiaries_countries_table cannot be reverted.\n";

        return false;
    }
    */
}
