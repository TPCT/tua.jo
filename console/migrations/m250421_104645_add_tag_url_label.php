<?php

use yii\db\Migration;

class m250421_104645_add_tag_url_label extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('donation_programs_tabs', 'label_url_en', $this->string()->defaultValue(null));
        $this->addColumn('donation_programs_tabs', 'label_url_ar', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250421_104645_add_tag_url_label cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250421_104645_add_tag_url_label cannot be reverted.\n";

        return false;
    }
    */
}
