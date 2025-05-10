<?php

use yii\db\Migration;

class m250327_083332_add_cms_title_to_module extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_types_lang', 'cms_title', $this->string()->defaultValue(null));
        $this->addColumn('sponsorship_families_lang', 'cms_title', $this->string()->defaultValue(null));
        $this->addColumn('campaigns_lang', 'cms_title', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250327_083332_add_cms_title_to_module cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250327_083332_add_cms_title_to_module cannot be reverted.\n";

        return false;
    }
    */
}
