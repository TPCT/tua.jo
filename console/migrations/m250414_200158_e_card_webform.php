<?php

use yii\db\Migration;

class m250414_200158_e_card_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('e_card_webform', [
            'id' => $this->primaryKey(),

            'amount' => $this->integer()->defaultValue(null),

            'sender_name' => $this->string(50)->defaultValue(null),
            'recipient_name' => $this->string(50)->defaultValue(null),
            'sender_email' => $this->string(255)->defaultValue(null),
            'recipient_email' => $this->string(255)->defaultValue(null),
            'recipient_mobile_number' => $this->string(255)->defaultValue(null),
            'sender_date' => $this->date()->defaultValue(null),

            'message' => $this->text()->defaultValue(null),

            'client_id' => $this->integer(11)->defaultValue(null),
            'e_card_id' => $this->integer(11)->defaultValue(null),

            'created_at' => $this->integer()->defaultValue(null),
        ]);

        

        $this->createIndex(
            'idx-e_card_webform-e_card_id',
            'e_card_webform',
            'e_card_id'
        );
        $this->addForeignKey(
            'fk-e_card_webform-e_card_id',
            'e_card_webform',
            'e_card_id',
            'e_cards',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_200158_e_card_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250414_200158_e_card_webform cannot be reverted.\n";

        return false;
    }
    */
}
