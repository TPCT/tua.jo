<?php

use yii\db\Migration;

class m250317_104221_add_category_id_to_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('faq', 'category_id', $this->integer()->defaultValue(null));

        $this->createIndex(
            'idx-faq-category_id',
            'faq',
            'category_id'
        );


        $this->addForeignKey(
            'fk-faq-category_id',
            'faq',
            'category_id',
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
        echo "m250317_104221_add_category_id_to_faq_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250317_104221_add_category_id_to_faq_table cannot be reverted.\n";

        return false;
    }
    */
}
