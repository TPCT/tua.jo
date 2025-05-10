<?php

use yii\db\Migration;

/**
 * Class m241014_225920_update_modules_tables
 */
class m241014_225920_update_modules_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('op_eds', 'country_id', $this->integer()->after('city_id'));
        $this->addColumn('discussion_papers', 'country_id', $this->integer()->after('city_id'));
        $this->addColumn('news', 'country_id', $this->integer()->after('city_id'));
        $this->addColumn('speeches', 'country_id', $this->integer()->after('city_id'));
        $this->addColumn('interviews', 'country_id', $this->integer()->after('city_id'));
        $this->addColumn('letters', 'country_id', $this->integer()->after('city_id'));





    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241014_225920_update_modules_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241014_225920_update_modules_tables cannot be reverted.\n";

        return false;
    }
    */
}
