<?php

use yii\db\Migration;

class m250413_190906_donation_gift_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('donation_gift_webform', [
            'id' => $this->primaryKey(),

            'amount' => $this->integer()->defaultValue(null),
            'sender_name' => $this->string(50)->defaultValue(null),
            'sender_email' => $this->string(255)->defaultValue(null),

            'recipient_name' => $this->string(50)->defaultValue(null),
            'recipient_email' => $this->string(255)->defaultValue(null),

            'sender_mobile_number' => $this->string(255)->defaultValue(null),
            'recipient_mobile_number' => $this->string(255)->defaultValue(null),

            'message' => $this->text()->defaultValue(null),


            'client_id' => $this->integer(11)->defaultValue(null),
            'e_card_id' => $this->integer(11)->defaultValue(null),


            'created_at' => $this->integer()->defaultValue(null),
        ]);

        

        $this->createIndex(
            'idx-donation_gift_webform-e_card_id',
            'donation_gift_webform',
            'e_card_id'
        );
        $this->addForeignKey(
            'fk-donation_gift_webform-e_card_id',
            'donation_gift_webform',
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
        echo "m250413_190906_donation_gift_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250413_190906_donation_gift_webform cannot be reverted.\n";

        return false;
    }
    */
}
