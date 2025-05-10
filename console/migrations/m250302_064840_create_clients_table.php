<?php

use yii\db\Migration;

class m250302_064840_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->null(),
            'password' => $this->string()->null(),
            'first_name' => $this->string()->null(),
            'last_name' => $this->string()->null(),
            'nationality' => $this->integer(3)->notNull(),
            'residency' => $this->integer(3)->notNull(),
            'country_code' => $this->string(4)->null(),
            'phone' => $this->string(21)->null(),
        ]);

        $this->createIndex('idx-clients-nationality', '{{%clients}}', 'nationality');
        $this->createIndex("idx-clients-residency", "{{%clients}}", "residency");

        $this->addForeignKey(
            'fk-clients-nationality',
            '{{%clients}}',
            'nationality',
            '{{%countries}}',
            'num_code',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-clients-residency',
            '{{%clients}}',
            'residency',
            '{{%countries}}',
            'num_code',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-clients-nationality', '{{%clients}}');
        $this->dropIndex('idx-clients-residency', '{{%clients}}');

        $this->dropForeignKey('fk-clients-nationality', 'clients');
        $this->dropForeignKey('fk-clients-residency', 'clients');

        $this->dropTable('clients');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250302_064840_create_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
