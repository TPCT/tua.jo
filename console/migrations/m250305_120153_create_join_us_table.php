<?php

use yii\db\Migration;

class m250305_120153_create_join_us_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('join_us_webform', [
            'id' => $this->primaryKey(),

            'name' => $this->string(255)->defaultValue(null),
            'mobile_number' => $this->string(50)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),
            'qualification' => $this->string(255)->defaultValue(null),
            'scientific_expertise' => $this->string(255)->defaultValue(null),
            'experience_year' => $this->integer()->defaultValue(null),

            'cv' => $this->text()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250305_120153_create_join_us_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250305_120153_create_join_us_table cannot be reverted.\n";

        return false;
    }
    */
}
