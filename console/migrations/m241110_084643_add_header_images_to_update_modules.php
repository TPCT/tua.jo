<?php

use yii\db\Migration;

/**
 * Class m241110_084643_add_header_images_to_update_modules
 */
class m241110_084643_add_header_images_to_update_modules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('discussion_papers_lang', 'header_image', $this->string()->null());
        $this->addColumn('discussion_papers_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('hashemites_lang', 'header_image', $this->string()->null());
        $this->addColumn('hashemites_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('interviews_lang', 'header_image', $this->string()->null());
        $this->addColumn('interviews_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('letters_lang', 'header_image', $this->string()->null());
        $this->addColumn('letters_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('news_lang', 'header_image', $this->string()->null());
        $this->addColumn('news_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('op_eds_lang', 'header_image', $this->string()->null());
        $this->addColumn('op_eds_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('speeches_lang', 'header_image', $this->string()->null());
        $this->addColumn('speeches_lang', 'mobile_header_image', $this->string()->null());
    
        $this->addColumn('youtube_links_lang', 'mobile_header_image', $this->string()->null());
        $this->addColumn('media_gallery_lang', 'mobile_header_image', $this->string()->null());
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241110_084643_add_header_images_to_update_modules cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241110_084643_add_header_images_to_update_modules cannot be reverted.\n";

        return false;
    }
    */
}
