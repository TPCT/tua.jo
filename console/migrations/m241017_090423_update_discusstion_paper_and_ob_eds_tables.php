<?php

use yii\db\Migration;

/**
 * Class m241017_090423_update_discusstion_paper_and_ob_eds_tables
 */
class m241017_090423_update_discusstion_paper_and_ob_eds_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('op_eds_lang', 'header_line', $this->string()->defaultValue('Op-Ed by His Majesty King Abdullah II'));
        $this->addColumn('op_eds_lang', 'media_outlet', $this->string());
        $this->addColumn('discussion_papers_lang', 'by', $this->string()->defaultValue('By Abdullah II ibn Al Hussein'));
        $this->addColumn('discussion_papers_lang', 'paper_number', $this->string());

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241017_090423_update_discusstion_paper_and_ob_eds_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241017_090423_update_discusstion_paper_and_ob_eds_tables cannot be reverted.\n";

        return false;
    }
    */
}
