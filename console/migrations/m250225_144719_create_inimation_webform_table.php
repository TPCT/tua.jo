<?php

use yii\db\Migration;

class m250225_144719_create_inimation_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('inimation_webform', [
            'id' => $this->primaryKey(),
            'inimation_webform' => $this->text(),
            'created_at' => $this->integer()->defaultValue(null),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250225_144719_create_inimation_webform_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250225_144719_create_inimation_webform_table cannot be reverted.\n";

        return false;
    }
    */
}
