<?php

use yii\db\Migration;

class m250420_115745_add_our_partner_id_to_bms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bms', 'our_partner_id', $this->integer()->defaultValue(null));

        $this->createIndex(
            'idx-bms-our_partner_id',
            'bms',
            'our_partner_id'
        );


        $this->addForeignKey(
            'fk-bms-our_partner_id',
            'bms',
            'our_partner_id',
            'dropdown_list',
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
        echo "m250420_115745_add_our_partner_id_to_bms_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_115745_add_our_partner_id_to_bms_table cannot be reverted.\n";

        return false;
    }
    */
}
