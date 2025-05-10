<?php

use yii\db\Migration;

class m250414_131938_create_promoted_campaign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('promoted_campaigns', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'image' => $this->string(255)->notNull(),
            'weight_order' => $this->tinyInteger()->defaultValue(10),
            'published_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'revision' => $this->integer()->notNull()->defaultValue(0),
            'changed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'reject_note' => $this->string(255),
        ]);

        $this->addForeignKey(
            'fk-promoted_campaigns-created_by',
            'promoted_campaigns',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-promoted_campaigns-updated_by',
            'promoted_campaigns',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create 'faq_lang' table
        $this->createTable('promoted_campaigns_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(255)->defaultValue(null),
            'brief' => $this->string(500)->defaultValue(null),

        ]);

        // Create foreign keys for 'faq_lang' table
        $this->addForeignKey(
            'fk-promoted_campaigns_lang-parent_id',
            'promoted_campaigns_lang',
            'parent_id',
            'promoted_campaigns',
            'id',
            'CASCADE',
            'CASCADE'
        );


        // Add indexes for 'promoted_campaign_lang'
        $this->createIndex(
            'idx-promoted_campaigns_lang-parent_id',
            'promoted_campaigns_lang',
            'parent_id'
        );
        $this->createIndex(
            'idx-promoted_campaigns_lang-language',
            'promoted_campaigns_lang',
            'language'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_131938_create_promoted_campaign_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_131938_create_promoted_campaign_table cannot be reverted.\n";

        return false;
    }
    */
}
