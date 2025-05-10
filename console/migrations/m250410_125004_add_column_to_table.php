<?php

use yii\db\Migration;

class m250410_125004_add_column_to_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // cart column to news
        $this->addColumn('news', 'campaign_id', $this->integer()->null());
        $this->addColumn('news', 'donation_type_id', $this->integer()->null());

        // cart column to blogs
        $this->addColumn('blogs', 'campaign_id', $this->integer()->null());
        $this->addColumn('blogs', 'donation_type_id', $this->integer()->null());

        // cart column to bms
        $this->addColumn('bms', 'campaign_id', $this->integer()->null());
        $this->addColumn('bms', 'donation_type_id', $this->integer()->null());

        

        // cart column to empowerment_product
        $this->addColumn('empowerment_product', 'campaign_id', $this->integer()->null());
        $this->addColumn('empowerment_product', 'donation_type_id', $this->integer()->null());

        // cart column to offer_tenders
        $this->addColumn('offer_tenders', 'campaign_id', $this->integer()->null());
        $this->addColumn('offer_tenders', 'donation_type_id', $this->integer()->null());

        // cart column to volunteer
        $this->addColumn('volunteer', 'campaign_id', $this->integer()->null());
        $this->addColumn('volunteer', 'donation_type_id', $this->integer()->null());

        // cart column to volunteer
        $this->addColumn('zakat_stories', 'campaign_id', $this->integer()->null());
        $this->addColumn('zakat_stories', 'donation_type_id', $this->integer()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250410_125004_add_column_to_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250410_125004_add_column_to_table cannot be reverted.\n";

        return false;
    }
    */
}
