<?php

use yii\db\Migration;

class m250309_223900_update_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
        $this->db->createCommand("DROP TABLE IF EXISTS `clients`")->execute();
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'guid' => $this->string()->notNull()->unique(),
            'email' => $this->string()->null(),
            'password' => $this->string()->null(),
            'first_name' => $this->string()->null(),
            'last_name' => $this->string()->null(),
            'nationality_id' => $this->integer(3)->notNull(),
            'residency_id' => $this->integer(3)->notNull(),
            'country_code' => $this->string(4)->null(),
            'phone' => $this->string(21)->null(),
        ]);

        $this->createIndex('idx-clients-nationality', '{{%clients}}', 'nationality_id');
        $this->createIndex("idx-clients-residency", "{{%clients}}", "residency_id");

        $this->addForeignKey(
            'fk-clients-nationality',
            '{{%clients}}',
            'nationality_id',
            '{{%countries}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-clients-residency',
            '{{%clients}}',
            'residency_id',
            '{{%countries}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250309_223900_update_clients_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_223900_update_clients_table cannot be reverted.\n";

        return false;
    }
    */
}
