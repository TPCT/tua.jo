<?php

use yii\db\Migration;

class m250420_074651_make_image_accept_multi_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("donation_programs_lang", "image", $this->string(255)->after("title")->null());

        $this->execute("
            UPDATE donation_programs_lang
            JOIN donation_programs ON donation_programs_lang.parent_id = donation_programs.id
            SET donation_programs_lang.image = donation_programs.image;
        ");

        $this->dropColumn("donation_programs", "image");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250420_074651_make_image_accept_multi_language cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250420_074651_make_image_accept_multi_language cannot be reverted.\n";

        return false;
    }
    */
}
