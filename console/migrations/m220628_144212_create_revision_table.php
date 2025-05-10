<?php

use yii\db\Migration;

/**
 * Class m220628_144212_create_revision_table
 */
class m220628_144212_create_revision_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("revision",[
            'id' => $this->primaryKey(),
            'model'=> $this->string(255),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            'idx-revision-created_by',
            'revision',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-revision-created_by',
            'revision',
            'created_by',
            'user',
            'id',
            'restrict',
            'cascade'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-revision-updated_by',
            'revision',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-revision-updated_by',
            'revision',
            'updated_by',
            'user',
            'id',
            'restrict',
            'cascade'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220628_144212_create_revision_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220628_144212_create_revision_table cannot be reverted.\n";

        return false;
    }
    */
}
