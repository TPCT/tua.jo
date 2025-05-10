<?php

use yii\db\Migration;

class m250406_140031_drop_number_type_id_from_volunteer_webform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-volunteer_webform-number_type_id', // name of the foreign key
            'volunteer_webform'                   // name of the table
        );
        
        $this->dropColumn('volunteer_webform', 'number_type_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250406_140031_drop_number_type_id_from_volunteer_webform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250406_140031_drop_number_type_id_from_volunteer_webform cannot be reverted.\n";

        return false;
    }
    */
}
